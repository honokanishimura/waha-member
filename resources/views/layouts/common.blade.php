<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <title>@yield('title')</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

@include('_includes.html_header')
@yield('original_css')

</head>
<body class="bg-img-num4" data-settings="open">
<main>
  @include('_includes.header')

  @yield('contents')

  @include('_includes.footer')
</main>

@include('_includes.html_footer')
@yield('original_foot_js')

  <!-- add js -->
  <script src="/js/plugins/jquery.validate/jquery.validate.min.js"></script>
  <script src="/js/plugins/jquery.validate/functions.js"></script>
  <script src="/assets/js/validation-setting.js"></script>
  <!-- /add js -->
</body>
</html>
