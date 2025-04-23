@extends('layouts.common')

@section('title', '会員一括操作')

@section('contents')
  <div class="main">
    
      <div class="container">
    
        <!-- breadcrumb -->
        <div class="row">
          <div class="col-xs-12">
            <ol class="breadcrumb">
              <li><a href="/">TOP</a></li>
              <li><a href="{{ route('members') }}">会員管理</a></li>
              <li class="active">会員一括操作</li>
            </ol>
          </div>
        </div>
        <!-- /breadcrumb -->
@if ($errors->any())
        <!-- alert -->
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-warning" role="alert">
              <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>会員情報一括登録に失敗しました
            </div>
          </div>
        </div>
        <!--/alert -->

@elseif (session()->has('token_mismatch_error'))
        <!-- alert -->
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-warning" role="alert">
              <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>ページの有効期限が切れました。再度送信してください。
            </div>
          </div>
        </div>
        <!--/alert -->

@endif
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
            <h1 class="col-xs-10">会員一括操作</h1>
          </div>
        </div>
        <!-- /h1 -->

        <!-- contentsbody -->
        <div class="contentsbody">
          <div class="row">
            <div class="col-xs-12">
              <div class="block">
                <div class="content controls">
                  <div class="form-row mb-30">
                    <div class="col-xs-2">会員情報一括ダウンロード</div>
                    <div class="col-xs-10">
                      <a href="{{ route('members.bulk_download') }}" class="btn btn-default">ダウンロード</a>
                    </div>
                  </div>
                  <form method="post" action="{{ route('members.bulk_upload') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                      <div class="col-xs-2">会員情報一括登録</div>
                      <div class="col-xs-3">
                        <a href="{{ route('members.bulk_template_download') }}" class="btn btn-info">登録用テンプレートダウンロード</a>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-xs-2"></div>
                      <div class="col-xs-8">
                        <input type="file" class="fileinput" name="bulk_upload_file" class="btn" title="ファイル選択">
@if ($errors->has('bulk_upload_file'))
                        <div class="validate-error">
                          @foreach ($errors->get('bulk_upload_file') as $message){{ $message }}<br>@endforeach
                        </div>
@endif
                      </div>
                      <div class="col-xs-2">
                        <button type="submit" class="btn btn-default">アップロード</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /table-content -->
      </div>
      <!-- container -->
  </div>
@endsection

@section('original_foot_js')
<script type="text/javascript" src="/js/plugins/bootstrap/bootstrap-file-input.js"></script>
@endsection
