<div class="col-xs-12 tac">
  <ul class="pagination">
@if ($page_info['now_page'] == 1)
    <li class="disabled"><a href="#" class="pager-page"><span class="icon-angle-left"></span></a></li>
@else
    <li><a href="#" class="pager-page" data-page="{!! $page_info['now_page'] - 1 !!}"><span class="icon-angle-left"></span></a></li>
@endif
@for ($i = $page_info['first_page']; $i <= $page_info['last_page']; $i++)
  @if ($i == $page_info['now_page'])
    <li class="active"><a href="#" class="pager-page">{!! $i !!}</a></li>
  @else
    <li><a href="#" class="pager-page" data-page="{!! $i !!}">{!! $i !!}</a></li>
  @endif
@endfor
@if ($page_info['now_page'] == $page_info['all_last_page'])
    <li class="disabled"><a href="#" class="pager-page"><span class="icon-angle-right"></span></a></li>
@else
    <li><a href="#" class="pager-page" data-page="{!! $page_info['now_page'] + 1 !!}"><span class="icon-angle-right"></span></a></li>
@endif
  </ul>
</div>
