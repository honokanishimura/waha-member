@extends('layouts.common')

@section('title', 'パスワード再設定')

@section('contents')
  <div class="main">
      <div class="container container-fixed">
    
        <!-- contentsbody -->
        <div class="contentsbody">
          <div class="row mb-20">
            <div class="col-xs-12">
              <div class="block form-content pt-70 pb-70">
                <!-- Login -->
                <div class="col-xs-6 col-xs-offset-3">
                <h1>パスワード再設定</h1>
                    <hr class="divider-w mt-10 mb-20">
                    <p>下記より新しいパスワードを入力し、「再設定」ボタンを押してください。<br>
                    半角数字、半角英数(大文字、小文字)を8文字以上組み合わせてください</p>
@if (session()->has('token_mismatch_error'))
                    <p class="text-danger">
                      ページの有効期限が切れました。再度送信してください。
                    </p>
@endif
                    <form id="form-reset" class="form" action="{{ route('signin.reset') }}" method="post">
                      @csrf
                      <input type="hidden" name="password_reset_token" value="{{ request()->token }}">
                      <div class="form-group">
                        <label for="password">パスワード</label>
                        <input class="form-control input-lg" id="password" type="password" name="password">
@if ($errors->has('password'))
                        <span id="password-error" class="validate-error">@foreach ($errors->get('password') as $message){{ $message }}<br>@endforeach</span>
@endif
                      </div>
                      <div class="form-group">
                        <label for="password-confirm">パスワード確認</label>
                        <input class="form-control input-lg" id="password-confirm" type="password" name="password_confirmation">
@if ($errors->has('password_confirmation'))
                        <span id="password-confirm-error" class="validate-error">@foreach ($errors->get('password_confirmation') as $message){{ $message }}<br>@endforeach</span>
@endif
                      </div>
                      <div class="form-group text-center mt-50">
                        <button type="submit" class="btn btn-round btn-b btn-lg w-300">再設定</button>
                      </div>
                      <div class="form-group text-center">
                        <a href="{{ route('signin') }}" class="btn btn-round btn-g btn-lg w-300">戻る</a>
                      </div>
                    </form>
                  </div>
                  <!-- /Login -->
              </div>
            </div>
          </div>
        </div>
        <!-- /contentsbody -->
    
      </div>
      <!-- container -->
  </div>
@endsection

@section('original_foot_js')
    <!-- add js -->
    <script src="/assets/js/jquery.validate/jquery.validate.min.js"></script>
    <script src="/assets/js/jquery.validate/functions.js"></script>
    <script src="/assets/js/signin/reset/validation-setting.js"></script>
    <!-- /add js -->
@endsection
