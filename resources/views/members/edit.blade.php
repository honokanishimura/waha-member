@extends('layouts.common')

@section('title', '会員編集')

@section('contents')
    <div class="main">
      <div class="container container-fixed">
    
        <!-- breadcrumb -->
        <div class="row">
          <div class="col-xs-12">
            <ol class="breadcrumb">
              <li><a href="/">TOP</a></li>
              <li><a href="{{ route('members') }}">会員管理</a></li>
              <li class="active">編集</li>
            </ol>
          </div>
        </div>
        <!-- /breadcrumb -->

@if (session()->has('member_edit_complete'))
        <!-- alert -->
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-info" role="alert">
              <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>保存しました
            </div>
          </div>
        </div>
        <!--/alert -->

@endif
        <!-- h1 -->
        <div class="row">
          <div class="col-xs-9 form-blk">
            <h1>会員編集</h1>
          </div>
        </div>
        <!-- /h1 -->
    
        <!-- contentsbody -->
        <div class="contentsbody">
          <div class="row mb-20">
            <div class="col-xs-12">
              <div class="block form-content">
                <div class="col-xs-9 waha-form-blk">
@if (session()->has('token_mismatch_error'))
                  <p class="text-danger">
                    ページの有効期限が切れました。再度送信してください。
                  </p>
@endif
                  <form id="form-register" class="form" action="{{ route('members.update', request()->member_id) }}" method="post">
                    @csrf
                    <!-- 会員ID -->
                    <div class="form-group">
                      <label for="disp-id">会員ID<strong class="text-danger">(必須)</strong></label>
@if ($errors->has('disp_id'))
                      <input class="form-control validate-error" id="disp-id" type="text" name="disp_id" value="{{ old('disp_id, $member->disp_id') }}" placeholder="A002000"  aria-describedby="disp-id-error" aria-invalid="true">
                      <span id="disp_id-error" class="validate-error">@foreach ($errors->get('disp_id') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="disp-id" type="text" name="disp_id" value="{{ old('disp_id', $member->disp_id) }}" placeholder="A002000">
@endif
                    </div>
                    <!-- ニックネーム -->
                    <div class="form-group">
                      <label for="nickname">ニックネーム</label>
@if ($errors->has('nickname'))
                      <input class="form-control validate-error" id="nickname" type="text" name="nickname" value="{{ old('nickname', $member->nickname) }}" placeholder="nickname" aria-describedby="nickname-error" aria-invalid="true">
                      <span id="nickname-error" class="validate-error">@foreach ($errors->get('nickname') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="nickname" type="text" name="nickname" value="{{ old('nickname', $member->nickname) }}" placeholder="nickname">
@endif
                      <p class="help-block fz-12">※半角英数6～12文字。今後、サイト内に追加されるコメント機能などで表示します。</p>
                    </div>
                    <!-- 会社名 -->
                    <div class="form-group">
                      <label for="company">会社名<strong class="text-danger">(必須)</strong></label>
@if ($errors->has('company'))
                      <input class="form-control validate-error" id="company" type="text" name="company" value="{{ old('company', $member->company) }}" placeholder="株式会社 カンパニー">
                      <span id="company-error" class="validate-error">@foreach ($errors->get('company') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="company" type="text" name="company" value="{{ old('company', $member->company) }}" placeholder="株式会社 カンパニー" aria-describedby="company-error" aria-invalid="true">
@endif
                    </div>
                    <!-- 部署名 -->
                    <div class="form-group">
                      <label for="department">部署名<strong class="text-danger">(必須)</strong></label>
@if ($errors->has('department'))
                      <input class="form-control validate-error" id="department" type="text" name="department" value="{{ old('department', $member->department) }}" placeholder="営業部" aria-describedby="department-error" aria-invalid="true">
                      <span id="department-error" class="validate-error">@foreach ($errors->get('department') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="department" type="text" name="department" value="{{ old('department', $member->department) }}" placeholder="営業部">
@endif
                      <p class="help-block fz-12">※ 『部署がない場合は、「なし」と入力してください』</p>
                    </div>
                    <!-- 役職 -->
                    <div class="form-group">
                      <label for="position">役職(任意)</label>
@if ($errors->has('position'))
                      <input class="form-control validate-error" id="position" type="text" name="position" value="{{ old('position', $member->position) }}" placeholder="課長" aria-describedby="position-error" aria-invalid="true">
                      <span id="position-error" class="validate-error">@foreach ($errors->get('position') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="position" type="text" name="position" value="{{ old('position', $member->position) }}" placeholder="課長">
@endif
                    </div>
                    <!-- 姓 -->
                    <div class="form-group">
                      <label for="lname">姓<strong class="text-danger">(必須)</strong></label>
@if ($errors->has('lname'))
                      <input class="form-control validate-error" id="lname" type="text" name="lname" value="{{ old('lname', $member->lname) }}" placeholder="姓" aria-describedby="lname-error" aria-invalid="true">
                      <span id="lname-error" class="validate-error">@foreach ($errors->get('lname') as $message){{ $message }}<br>@endforeach</span>
@else
                    <input class="form-control" id="lname" type="text" name="lname" value="{{ old('lname', $member->lname) }}" placeholder="姓">
@endif
                    </div>
                    <!-- 名 -->
                    <div class="form-group">
                      <label for="fname">名<strong class="text-danger">(必須)</strong></label>
@if ($errors->has('fname'))
                      <input class="form-control validate-error" id="fname" type="text" name="fname" value="{{ old('fname', $member->fname) }}" placeholder="名" aria-describedby="fname-error" aria-invalid="true">
                      <span id="fname-error" class="validate-error">@foreach ($errors->get('fname') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="fname" type="text" name="fname" value="{{ old('fname', $member->fname) }}" placeholder="名">
@endif
                    </div>
                    <!-- メールアドレス -->
                    <div class="form-group">
                      <label for="email">メールアドレス<strong class="text-danger">(必須)</strong></label>
@if ($errors->has('email'))
                      <input class="form-control validate-error" id="email" type="email" name="email" value="{{ old('email', $member->email) }}" placeholder="法人メールアドレスを入力してください" aria-describedby="email-error" aria-invalid="true">
                      <span id="email-error" class="validate-error">@foreach ($errors->get('email') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $member->email) }}" placeholder="法人メールアドレスを入力してください">
@endif
                    </div>
                    <!-- パスワード -->
                    <div class="form-group">
                      <label for="password">パスワード</label>
@if ($errors->has('password'))
                      <input class="form-control validate-error" id="password" type="password" name="password" aria-describedby="password-error" aria-invalid="true">
                      <span id="password-error" class="validate-error">@foreach ($errors->get('password') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="password" type="password" name="password">
@endif
                      <p class="help-block fz-12">※パスワードを変更する場合は入力してください<br>※ 半角数字、半角英数(大文字、小文字)を8文字以上組み合わせてください</p>
                    </div>
                    <!-- パスワード確認 -->
                    <div class="form-group">
                      <label for="password-confirm">パスワード確認</label>
@if ($errors->has('password_confirmation'))
                      <input class="form-control validate-error" id="password-confirm" type="password" name="password_confirmation" aria-describedby="password-confirm-error" aria-invalid="true">
                      <span id="password-confirm-error" class="validate-error">@foreach ($errors->get('password_confirmation') as $message){{ $message }}<br>@endforeach</span>
@else
                      <input class="form-control" id="password-confirm" type="password" name="password_confirmation">
@endif
                      <p class="help-block fz-12">※パスワードを変更する場合は入力してください</p>
                    </div>
                    <!-- 業種 -->
                    <div class="form-group">
                      <label for="industry">業種</label>
@if ($errors->has('industry'))
                      <select class="form-control validate-error" name="industry" id="industry" aria-describedby="industry-error" aria-invalid="true">
@else
                      <select class="form-control" name="industry" id="industry">
@endif
                        <option value="">--- 未選択 ---</option>
@foreach (config('const.member.industry') as $value => $label)
                        <option value="{{ $value }}"{!! (int) old('industry', $member->industry) === $value ? ' selected="selected"' : '' !!}>{{ $label }}</option>
@endforeach
                      </select>
@if ($errors->has('industry'))
                      <span id="industry-error" class="validate-error">@foreach ($errors->get('industry') as $message){{ $message }}<br>@endforeach</span>
@endif
                    </div>
                    <!-- 勤務地 -->
                    <div class="form-group">
                      <label for="location">勤務地</label>
@if ($errors->has('location'))
                      <select class="form-control validate-error" name="location" id="location" aria-describedby="location-error" aria-invalid="true">
@else
                      <select class="form-control" name="location" id="location">
@endif
                        <option value="">--- 未選択 ---</option>
@foreach (config('const.member.location') as $value => $label)
                        <option value="{{ $value }}"{!! (int) old('location', $member->location) === $value ? ' selected="selected"' : '' !!}>{{ $label }}</option>
@endforeach
                      </select>
@if ($errors->has('location'))
                      <span id="location-error" class="validate-error">@foreach ($errors->get('location') as $message){{ $message }}<br>@endforeach</span>
@endif
                    </div>
                    <!-- 従業員規模 -->
                    <div class="form-group">
                      <label for="employee">従業員規模</label>
@if ($errors->has('employee'))
                      <select class="form-control validate-error" name="employee" id="employee" aria-describedby="employee-error" aria-invalid="true">
@else
                      <select class="form-control" name="employee" id="employee">
@endif
                        <option value="">--- 未選択 ---</option>
@foreach (config('const.member.employee') as $value => $label)
                        <option value="{{ $value }}"{!! (int) old('employee', $member->employee) === $value ? ' selected="selected"' : '' !!}>{{ $label }}</option>
@endforeach
                      </select>
@if ($errors->has('employee'))
                      <span id="employee-error" class="validate-error">@foreach ($errors->get('employee') as $message){{ $message }}<br>@endforeach</span>
@endif
                      <p class="help-block fz-12">※パート・アルバイト等を除く</p>
                    </div>
                    <!-- 所属部門 -->
                    <div class="form-group">
                      <label for="affiliation">所属部門</label>
@if ($errors->has('affiliation'))
                      <select class="form-control validate-error" name="affiliation" id="affiliation" aria-describedby="affiliation-error" aria-invalid="true">
@else
                      <select class="form-control" name="affiliation" id="affiliation">
@endif
                        <option value="">--- 未選択 ---</option>
@foreach (config('const.member.affiliation') as $value => $label)
                        <option value="{{ $value }}"{!! (int) old('affiliation', $member->affiliation) === $value ? ' selected="selected"' : '' !!}>{{ $label }}</option>
@endforeach
                      </select>
@if ($errors->has('affiliation'))
                      <span id="affiliation-error" class="validate-error">@foreach ($errors->get('affiliation') as $message){{ $message }}<br>@endforeach</span>
@endif
                    </div>
    
                    <div class="form-group waha-data">
                      <label>取扱いデータ<span class="help-block fz-12">※複数選択可</span></label>
@foreach (config('const.member.handling') as $value => $label)
                      <div class="checkbox">
                        <label><input type="checkbox" name="handling[]" value="{{ $value }}"{!! is_array(old('handling', $member_handlings)) && in_array($value, old('handling', $member_handlings)) ? ' checked="checked"' : '' !!}>{{ $label }}</label>
                      </div>
@endforeach
@if ($errors->has('handling'))
                    <span id="handling-error" class="validate-error">@foreach ($errors->get('handling') as $message){{ $message }}<br>@endforeach</span>
@endif
@if ($errors->has('handling.*'))
                    <span id="handling-error" class="validate-error">選択肢から選択してください</span>
@endif
                    </div>

                    <div class="form-group waha-data">
                      <label>最終ログイン日時</label>
                      <div class="checkbox">
                        {{$member->last_loggedin_at}}
                      </div>
                    </div>

                    <div class="form-group waha-data">
                      <label>登録日時</label>
                      <div class="checkbox">
                        {{$member->created_at}}
                      </div>
                    </div>

                    <!-- 内容を確認ボタン -->
                    <div class="form-group tac">
                      <div class="tac">
                        <button class="btn btn-default w-300" type="submit">保存</button>
                      </div>
                      <div class="tac mt-20">
                        <a class="btn btn-default btn-clean w-300" href="{{ route('members') }}">キャンセル</a>
                      </div>
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
  <script src="/assets/js/members/edit/validation-setting.js"></script>
  <!-- /add js -->
@endsection
