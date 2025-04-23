@extends('layouts.common')

@section('title', 'パスワードを忘れた方へ')

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
                <h1>パスワードを忘れた方へ</h1>
                    <hr class="divider-w mt-10 mb-20">
                    <p>下記よりメールアドレスを入力して「リセット」ボタンを押してください。<br>
                    パスワード再設定URLをメールにてお送りいたします。</p>
@if (session()->has('global_error'))
                    <p class="text-danger">
                      {{ session()->get('global_error') }}
                    </p>
@elseif (session()->has('token_mismatch_error'))
                    <p class="text-danger">
                      ページの有効期限が切れました。再度送信してください。
                    </p>
@endif
                    <form id="form-reminder" class="form" action="{{ route('signin.password') }}" method="post">
                      @csrf
                      <div class="form-group">
                        <label for="email">メールドレス</label>
                        <input class="form-control input-lg" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="member@waha-transformer.com">
                      </div>
@if ($errors->has('email'))
                    <span id="email-error" class="validate-error">@foreach ($errors->get('email') as $message){{ $message }}<br>@endforeach</span>
@endif
                      <div class="form-group text-center mt-50">
                        <button type="submit" class="btn btn-round btn-b btn-lg w-300">パスワードリセット</button>
                      </div>
                      <div class="form-group text-center">
                        <a href="{{ route('members') }}" class="btn btn-round btn-g btn-lg w-300">戻る</a>
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
  <script src="/js/plugins/jquery.validate/jquery.validate.min.js"></script>
  <script src="/js/plugins/jquery.validate/functions.js"></script>
  <script src="/assets/js/signin/password/validation-setting.js"></script>
  <!-- /add js -->
@endsection
