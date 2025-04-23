@extends('layouts.common')

@section('title', '会員管理')

@section('contents')
  <div class="main">
    
      <div class="container">
    
        <!-- breadcrumb -->
        <div class="row">
          <div class="col-xs-12">
            <ol class="breadcrumb">
              <li><a href="/">TOP</a></li>
              <li class="active">会員管理</li>
            </ol>
          </div>
        </div>
        <!-- /breadcrumb -->
    
@if (session()->has('member_bulk_update_complete'))
        <!-- alert -->
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-info" role="alert">
              <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>{{ session()->get('member_bulk_update_complete') }}
            </div>
          </div>
        </div>
        <!--/alert -->

@endif

        <!-- h1 -->
        <div class="row">
          <div class="col-xs-12">
            <h1 class="col-xs-10">会員一覧</h1>
          </div>
        </div>
        <!-- /h1 -->
    
        <!-- contentsbody -->
        <div class="contentsbody">
          <div class="row">
            <div class="col-xs-12">
              <div class="block">
                <div class="header">
                  <p class="status">ステータス</p>
                  <div class="form-row">
                    <div class="col-xs-8 btn-blk btn-group-sm form-status pt-5 pb-5" id="status-conditions">
                      <a class="btn" href="#" id="status-condition-all">すべて</a>
                      <a class="btn" href="#" id="status-condition-2" data-status-id="2">仮登録</a>
                      <a class="btn" href="#" id="status-condition-4" data-status-id="4">有効</a>
                      <a class="btn" href="#" id="status-condition-3"data-status-id="3">無効</a>
                      <a class="btn" href="#" id="status-condition-5"data-status-id="5">退会</a>
                    </div>
                    <div class="col-xs-4">
                      <form action="#" id="keyword-condition-form">
                        <div class="input-group">
                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-default serch-btn"><span class="icon-search"></span></button>
                          </div>
                          <input type="text" class="form-control" id="keyword-condition" placeholder="キーワードで探す">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
    
                <div class="content">
                  <div role="grid">
                    <div class="form-row">
                      <div class="form-blk col-xs-10 btn-width">
                        <form method="post" action="{{ route('members.bulk_update') }}" class="d-inline-flex" id="blk-update-form">
                          @csrf
                          <div class="btn-group">
                            <select name="blk_action" class="status-selector" id="blk-action">
                              <option value="">一括変更</option>
                              <option value="4">ステータスを有効にする</option>
                              <option value="3">ステータスを無効にする</option>
                              <option value="6">削除する</option>
                            </select>
                          </div>
                          <div class="btn-group ml-10">
                            <button type="submit" class="btn btn-default" id="blk-update-btn">実行</button>
                          </div>
                        </form>

                        <div class="btn-group ml-40">
                          <div class="modal fade" id="js-delModal" tabindex="-1" role="dialog" aria-labelledby="js-delModal" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="mb-0">削除の確認</h3>
                                </div>
                                <div class="modal-body">
                                  <p class="fz-16">選択したユーザーを削除します。よろしいですか？</p>
                                  <p class="text-mute">※ 削除は取り消すことができません<br>※ 削除後のアカウント復活はシステム担当者への依頼が必要です</p>
                                </div>
                                <div class="modal-footer">
                                  <form method="post" action="{{ route('members.bulk_update') }}" id="blk-delete-form">
                                    @csrf
                                    <input type="hidden" name="blk_action" value="6">
                                    <button type="button"class="btn btn-default"data-dismiss="modal">キャンセル</button>
                                    <button type="submit"class="btn btn-default btn-clean">削除する</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

{{--
                      <div class="form-blk col-xs-2 tar"><a href="/members/new/" class="btn btn-link"><u>＋&nbsp;新規作成</u></a></div>
--}}
                    </div>

                    <table class="table table-bordered table-striped" id="members-table">
                      <thead>
                        <tr role="row">
                          <th role="columnheader" rowspan="1" colspan="1" style="width: 18px;">
                            <div class="checker"><span><input type="checkbox" class="checkall"></span></div>
                          </th>
                          <th>
                            <div class="table-ttl">
                              <a href="#" class="sort-item" id="sort-item-condition-disp_id" data-sort-item-name="disp_id">会員ID
                                <div class="table-icon">
                                  <i class="icon-caret-up"></i>
                                  <i class="icon-caret-down"></i>
                                </div>
                              </a>
                            </div>
                          </th>
                          <th>
                            <div class="table-ttl">
                              <a href="#" class="sort-item" id="sort-item-condition-status" data-sort-item-name="status">ステータス
                              <div class="table-icon">
                                <i class="icon-caret-up"></i>
                                <i class="icon-caret-down"></i>
                              </div>
                            </a>
                          </div>
                          </th>
                          <th>
                            <div class="table-ttl">
                              <a href="#" class="sort-item" id="sort-item-condition-name" data-sort-item-name="name">氏名
                                <div class="table-icon">
                                  <i class="icon-caret-up"></i>
                                  <i class="icon-caret-down"></i>
                                </div>
                              </a>
                            </div>
                          </th>
                          <th>
                            <div class="table-ttl">
                              <a href="#" class="sort-item" id="sort-item-condition-company" data-sort-item-name="company">会社名
                                <div class="table-icon">
                                  <i class="icon-caret-up"></i>
                                  <i class="icon-caret-down"></i>
                                </div>
                              </a>
                            </div>
                          </th>
                          <th>
                            <div class="table-ttl">
                              <a href="#" class="sort-item" id="sort-item-condition-department" data-sort-item-name="department">部署名
                                <div class="table-icon">
                                  <i class="icon-caret-up"></i>
                                  <i class="icon-caret-down"></i>
                                </div>
                              </a>
                            </div>
                          </th>
                          <th>
                            <div class="table-ttl">
                              <a href="#" class="sort-item" id="sort-item-condition-email" data-sort-item-name="email">メールアドレス
                                <div class="table-icon">
                                  <i class="icon-caret-up"></i>
                                  <i class="icon-caret-down"></i>
                                </div>
                              </a>
                            </div>
                          </th>
                          <th>
                            <div class="table-ttl">
                              <a href="#" class="sort-item" id="sort-item-condition-last_loggedin_at" data-sort-item-name="last_loggedin_at">最終ログイン
                                <div class="table-icon">
                                  <i class="icon-caret-up"></i>
                                  <i class="icon-caret-down"></i>
                                </div>
                              </a>
                            </div>
                          </th>
                          <th>
                            <div class="table-ttl">
                              <a href="#" class="sort-item" id="sort-item-condition-created_at" data-sort-item-name="created_at">登録日時
                                <div class="table-icon">
                                  <i class="icon-caret-up"></i>
                                  <i class="icon-caret-down"></i>
                                </div>
                              </a>
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <tbody role="alert" aria-live="polite" aria-relevant="all"></tbody>
                    </table>
                  </div>
                </div>
    
              </div>
            </div>
          </div>
        </div>
        <!-- /table-content -->
    
        <!-- pager -->
        <div class="row" id="pager"></div>
        <!-- /pager -->
      </div>
      <!-- container -->
  </div>
@endsection

@section('original_foot_js')
  <!-- add js -->
  <script src="/assets/js/members/index.js"></script>
  <!-- /add js -->
@endsection
