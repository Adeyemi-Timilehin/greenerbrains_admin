<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!--=============== basic  ===============-->
  <meta charset="UTF-8">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'GreenerBrains') }} - @yield('title')</title>
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <!--=============== css  ===============-->
  <link rel="stylesheet" href="{{ asset('front/css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('front/css/plugins.css') }}">
  <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('front/css/color.css') }}">
  <link rel="stylesheet" href="{{ asset('front/css/custom.css') }}">
  <!--=============== favicons ===============-->
  <link rel="shortcut icon" href="{{ asset('front/images/favicon.ico')}}">
  @stack('styles')
</head>

<body>
  <!--loader-->
  <div class="loader-wrap">
    <div class="loader-inner">
      <div class="loader-inner-cirle"></div>
    </div>
  </div>
  <!--loader end-->
  <!-- main start  -->
  <div id="main">
      
    <!-- content-->
      @yield('content')
    <!--content end-->

    <a class="to-top"><i class="fas fa-caret-up"></i></a>
  </div>
  <!-- Main end -->
  <!--=============== scripts  ===============-->
  <!-- @stack('scripts') -->
  <script src="{{ asset('front/js/jquery.min.js') }}"></script>
  <script src="{{ asset('front/js/plugins.js') }}"></script>
  <script src="{{ asset('front/js/scripts.js') }}"></script>
</body>
</html>