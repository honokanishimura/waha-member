$(function() {

  // 検索条件
  var conditions = {};

  loadParameters(window.location.search);
  renderConditions();

  // 戻る・進む実行時のイベント
  window.addEventListener('popstate', function (e) {
    loadParameters(e.target.location.search);
    renderConditions();
  });

  // ステータス条件変更イベント
  $('#status-conditions a').on('click', function(e) {
    e.stopPropagation();
    e.preventDefault();

    conditions.status = $(this).data('status-id');
    conditions.page = undefined;
    renderConditions();
  });

  // ソート条件変更イベント
  $('.sort-item').on('click', function(e) {
    e.stopPropagation();
    e.preventDefault();

    var sort_by = $(this).data('sort-item-name');
    var sort_order = 'asc';
    if (conditions.sort_by === sort_by && conditions.sort_order === 'asc') {
      sort_order = 'desc';
    }

    conditions.sort_by = sort_by;
    conditions.sort_order = sort_order;
    conditions.page = undefined;
    renderConditions();
  });

  // キーワード変更イベント
  $('#keyword-condition-form').on('submit', function(e) {
    e.stopPropagation();
    e.preventDefault();

    conditions.keyword = $('#keyword-condition').val();
    conditions.page = undefined;
    renderConditions();
  });

  // ページ変更イベント
  $(document).on('click', '.pager-page', function(e) {
    e.stopPropagation();
    e.preventDefault();

    if ($(this).data('page') === undefined) return;

    conditions.page = $(this).data('page');
    renderConditions();
  });

  // 一括削除、一括ステータス変更フォームサブミット
  $('#blk-delete-form, #blk-update-form').on('submit', function(e) {
    if ($(this).attr('id') === 'blk-update-form') {
      // 選択されていない
      if ($('#blk-action').val() === '') {
        e.preventDefault();
        return;
      }
      // 「削除する」選択時
      else if ($('#blk-action').val() === '6') {
        e.preventDefault();

        $('#js-delModal').modal('show')

        return;
      }
    }

    var $form = $(this);
    $('.checked input[name="member_id[]"]').each(function() {
      $form.append('<input type="hidden" name="member_id[]" value="' + $(this).val() + '">');
    });
  });

  // GETパラメータを取得して初期値にセット
  function loadParameters(search) {
    conditions.status = undefined;
    conditions.keyword = '';
    conditions.sort_by = undefined;
    conditions.sort_order = undefined;
    conditions.page = undefined;

    if (search === '') return;

    var query = window.location.search.substring(1);
    var parameters = query.split('&');

    for (var i = 0; i < parameters.length; i++) {
      var element = parameters[i].split('=');

      var name = decodeURIComponent(element[0]);
      if (name === 'status') {
        conditions.status = decodeURIComponent(element[1]);
      }
      else if (name === 'keyword') {
        conditions.keyword = decodeURIComponent(element[1]);
      }
      else if (name === 'sort_by') {
        conditions.sort_by = decodeURIComponent(element[1]);
      }
      else if (name === 'sort_order') {
        conditions.sort_order = decodeURIComponent(element[1]);
      }
      else if (name === 'page') {
        conditions.page = decodeURIComponent(element[1]);
      }
    }
  }

  // 条件に合わせて表示調整
  function renderConditions() {
    // ステータス
    $('#status-conditions a').removeClass('btn-default');
    if (conditions.status === undefined) {
      $('#status-condition-all').addClass('btn-default');
    }
    else {
      $('#status-condition-' + conditions.status).addClass('btn-default');
    }

    // ソート条件
    var sort_by = 'disp_id';
    if (conditions.sort_by !== undefined) {
      sort_by = conditions.sort_by;
    }

    var sort_order = 'desc';
    if (conditions.sort_order !== undefined) {
      sort_order = conditions.sort_order;
    }

    $('.sort-item i').removeClass('active');
    if (sort_order === 'asc') {
      $('#sort-item-condition-' + sort_by).find('i.icon-caret-up').addClass('active');
    }
    else {
      $('#sort-item-condition-' + sort_by).find('i.icon-caret-down').addClass('active');
    }

    // キーワード
    $('#keyword-condition').val(conditions.keyword);

    search();
  }

  // 検索処理
  function search() {
    var url = '/members/search_ajax';

    var url_condition = '';
    var url_conditions = [];
    for (var key in conditions) {
      if (conditions[key] !== undefined && conditions[key] !== '') {
        url_conditions.push(key + '=' + encodeURIComponent(conditions[key]));
      }
    }

    if (url_conditions.length > 0) {
      url_condition =  '?' + url_conditions.join('&');
      url = url + url_condition;
    }

    $.ajax({
      url: url,
      type: 'get',
      dataType: 'json',
      async: false,
    })
    .done(function(data, textStatus, jqXHR) {
      $('#members-table tbody').empty().html(data.tbody)
      $('#members-table tbody').find(':checkbox').uniform();
      $('#pager').empty().html(data.pager);
      $('.checkall').prop('checked', false);
      $('.checkall').parent().removeClass('checked');

      if (window.history && window.history.pushState) {
        var new_path = '/members' + url_condition;
        if (new_path !== window.location.pathname + window.location.search) {
          history.pushState(null, '会員一覧', new_path);
        }
      }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
    })
    .always(function(jqXHR, textStatus ) {
    });
  }
});
