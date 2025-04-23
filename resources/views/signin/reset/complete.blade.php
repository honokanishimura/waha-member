@extends('layouts.common')

@section('title', 'パスワード再設定完了')

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
                <h1>パスワード再設定完了</h1>
                    <hr class="divider-w mt-10 mb-20">
                    <p>パスワードの設定が完了しました。<br>
                    サインイン画面に戻り、新しいパスワードでサインインしてください。</p>
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
