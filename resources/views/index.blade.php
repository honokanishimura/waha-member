@extends('layouts.common')

@section('title', 'ログイン')

@section('contents')
<div class="main">
    
    <div class="container container-fixed">

      <!-- h1 -->
      <div class="row">
        <div class="col-xs-12">
          <h1 class="col-xs-10">ログイン</h1>
        </div>
      </div>
      <!-- /h1 -->
  
      <!-- content -->
      <div clas="contentsbody">
        <div class="row">
          <div class="login-block">
@if (session()->has('login_global_error'))
            <p class="text-danger">
              {{ session()->get('login_global_error') }}
            </p>

@elseif (session()->has('token_mismatch_error'))
                <p class="text-danger">
                  ページの有効期限が切れました。再度送信してください。
                </p>

@endif
            <div class="block block-transparent">
              <div class="content controls npt">
                <form id="form-login" class="form" action="{{ route('signin') }}" method="post" novalidate="novalidate">
                  @csrf
                  <div class="form-group">
                    <label for="login-email">メールアドレス</label>
                    <input class="form-control input-lg" id="login-email" type="email" name="login-email" value="{{ old('login-email') }}" placeholder="member@waha-transformer.com">
@if ($errors->has('login-email'))
                    <span id="login-email-error" class="validate-error">@foreach ($errors->get('login-email') as $message){{ $message }}<br>@endforeach</span>
@endif
                  </div>
                  <div class="form-group">
                    <label for="login-password">パスワード</label>
                    <input class="form-control input-lg" id="login-password" type="password" name="login-password">
@if ($errors->has('login-password'))
                    <span id="login-password-error" class="validate-error">@foreach ($errors->get('login-password') as $message){{ $message }}<br>@endforeach</span>
@endif
                  </div>
                  <div class="form-group text-center mt-50">
                    <button type="submit" class="btn btn-default btn-block">ログイン</button>
                  </div>
                  <div class="form-group text-center">
                    <a href="/signin/password/"><u>パスワードを忘れた方へ</u></a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /content -->
    </div>
    <!-- container -->
  </div>
@endsection

@section('original_foot_js')
  <!-- add js -->
  <script src="/js/plugins/jquery.validate/jquery.validate.min.js"></script>
  <script src="/js/plugins/jquery.validate/functions.js"></script>
  <script src="/assets/js/validation-setting.js"></script>
  <!-- /add js -->
@endsection