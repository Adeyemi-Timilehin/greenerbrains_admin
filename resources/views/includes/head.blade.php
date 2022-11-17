<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="{{ config('app.name') }} Mobile Dashboard<">
    <meta name="author" content="greenerbrains">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'GreenerBrains') }} </title>

    <!-- vendor css -->
    <link href="{{asset('lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{asset('lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link href="{{asset('lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{asset('lib/highlightjs/github.css') }}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/decoupled-document/ckeditor.js"></script>
    {{-- <script src="{{ asset('js/ckeditor.js') }}"></script> --}}
    <!-- magen-iot-admin CSS -->
    <link rel="stylesheet" href="{{asset('css/magen-iot-admin.css') }}">
    <link crossorigin="anonymous" media="all" rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet" />

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link href="/css/video-js.min.css" rel="stylesheet">
    <script src="/js/video.min.js"></script>

    <style>
        .kt-sideleft-menu .icon{
            color: #6cc091;
        }
        .kt-sideleft-menu .fa {
            color: #6cc091;
        }
        .pagination .active .page-link{
            background-color: #6cc091;
        }
        .pagination .active .page-link:hover{
            background-color: #6cc091;
        }
        .align-items-center .icon.ion-star {
            color: #6cc091;
        }
        .kt-sideleft-menu, .kt-input-search, .kt-sidebar-label {
            border-right: 2px solid #6cc091;
        }
        .btn-primary, .btn-primary:hover, .btn-secondary, .btn-secondary:hover, a .btn-secondary, a .btn-secondary:hover{
            background-color: #6cc091 !important;
            border-color: #6cc091 !important;
            color: white;
        }
        a:hover{
            /* color:#6cc091; */
        }

        a.nav-link span {
            color: #555;
            font-weight: bolder;
            letter-spacing: 0.1px;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .kt-logo a {
            /* color:#6cc091; */
            font-weight: bold;
        }
        .kt-logo a:hover {
            /* color:#6cc091; */
            font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }
    </style>
</head>
