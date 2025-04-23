@extends('layouts.common')

@section('title', 'パスワードを忘れた方へ(メール送信)')

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
                <h1>パスワードを忘れた方へ(メール送信)</h1>
                    <hr class="divider-w mt-10 mb-20">
                    <p>入力していただいたメールアドレス宛にパスワード再設定用のURLを記載したメールを送信いたしました。<br>
                    メール内のリンクにアクセスしてパスワード再設定を行ってください。</p>
                    <div class="text-center mt-50">
                      <a href="{{ route('signin') }}" class="btn btn-round btn-g btn-lg w-300">サインインページへ</a>
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
