  <!-- page header -->
  <div class="header">
  <div class="row">
    <div class="container">
      <div class="col-xs-12">
        <nav class="navbar brb block-fill-white" role="navigation">
          <div class="navbar-header header">
          <!-- Here your logo or another info -->
            <a class="navbar-brand logo-bg-color" href="{{ route('signin') }}">
            <img src="/assets/images/common/waha_white.png" alt="トップページ" >
            <span>会員管理画面</span>
            </a>
          </div>
@if (Auth::Check())
          <div class="collapse navbar-collapse collapse-show" id="custom-collapse"> <!-- Top navigation -->
            <ul class="nav navbar-nav">
              <li><a href="{{ route('members') }}"><i class="icon-pencil"></i> 会員一覧</a></li>
              <li><a href="{{ route('members.create') }}"><i class="icon-plus"></i> 会員新規登録</a></li>
              <li><a href="{{ route('members.bulk') }}"><i class="icon-group"></i> 会員一括操作</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right nav-id" role="search">
              <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::User()->name }} ▼</a>
                <ul class="dropdown-menu"><!-- sub items -->
                  <li><a href="{{ route('signout') }}">ログアウト</a></li><!-- subitem -->
                </ul>
              </li>
            </ul>
          </div>
@endif
        </nav>
      </div>
    </div>
  </div>
</div>
  <!-- /header -->