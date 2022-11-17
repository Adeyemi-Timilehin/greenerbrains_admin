<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- ####### HEAD  -->
@include('includes.head')

<body>
    <!-- ##### SIDEBAR LOGO ##### -->
    <div class="kt-sideleft-header">
        <div class="kt-logo">
        <a href="{{ route('index') }}">{{ config('app.name') }}</a>
        </div>
        <div id="ktDate" class="kt-date-today"></div>
        <div class="input-group kt-input-search">
            <input type="text" class="form-control" placeholder="Search..." />
            <span class="input-group-btn mg-0">
                <button class="btn"><i class="fa fa-search"></i></button>
            </span>
        </div>
        <!-- input-group -->
    </div>
    <!-- kt-sideleft-header -->

    <!-- ##### SIDEBAR MENU ##### -->
    @include('includes.sidebar')

    <!-- ##### HEAD PANEL ##### -->
    @include('includes.header')

    <div class="kt-breadcrumb">
        <nav class="breadcrumb">
            {{-- <a class="breadcrumb-item" href="/">GreenerBrains</a>
            <a class="breadcrumb-item" href="index.html">Tables</a>
                <span class="breadcrumb-item active">Basic Tables</span> --}}
        </nav>
    </div>
    <!-- kt-breadcrumb -->

    <!-- ##### MAIN PANEL ##### -->
    <div class="kt-mainpanel">
        <!-- ##### BODY #### -->
        @yield('content')

        <!-- ###### FOOTER ###### -->
        @include('includes.footer')
    </div>
    <!-- kt-mainpanel -->

    <script src="{{ asset('lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('lib/popper.js/popper.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/bootstrap.js') }}"></script>
    <script src="{{
                asset('lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')
            }}"></script>
    <script src="{{ asset('lib/moment/moment.js') }}"></script>
    <script src="{{ asset('lib/highlightjs/highlight.pack.js') }}"></script>
    <!-- <script src="{{ asset('lib/medium-editor/medium-editor.js') }}"></script>
        <script src="{{ asset('lib/summernote/summernote-bs4.min.js') }}"></script> -->

    <script src="{{ asset('js/magen-iot-admin.js') }}"></script>
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@9.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="/__/firebase/7.15.1/firebase-app.js"></script>
    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="/__/firebase/7.15.1/firebase-analytics.js"></script>
    <!-- Initialize Firebase -->
    {{-- <script src="/__/firebase/init.js"></script> --}}
</body>
<script>
    // var startTime = localStorage.getItem("init_time"),
    //     timeoutLength = 200;
    // const MINUTES_UNTIL_AUTO_LOGOUT = 120 // in mins
    // const CHECK_INTERVAL = 1000 // in ms

    // function check() {
    //     const now = Date.now();
    //     const timeleft = parseInt(localStorage.getItem("init_time"), 10) + MINUTES_UNTIL_AUTO_LOGOUT * 60 * 1000;
    //     const diff = timeleft - now;
    //     const isTimeout = diff < 0;

    //     if (isTimeout && API.isLoggedIn()) {
    //         API.logout();
    //         let url = '/admin/auth/login';
    //         window.location.href = url;
    //     }
    // }

    // setInterval(() => {
    //     check();
    // }, CHECK_INTERVAL);

    // function checkTimeout() {
    //     console.log("Checking timeout");
    //     var currentTime = new Date().getTime();
    //     console.log(currentTime, (currentTime - startTime), (currentTime - (startTime + timeoutLength)) > 0);
    //     if ((currentTime - (startTime + timeoutLength)) > 0) {
    //         alert("Your current Session is over due to inactivity.");
    //         API.logout();
    //         let url = '/admin/auth/login';
    //         window.location.href = url;
    //         clearInterval(interval);
    //     }
    // }


    // var interval = setInterval(check(), 1000);

    // if (!API.isLoggedIn()) {
    //     window.location.href = "/admin/auth/login";
    // } else {
    //     if (API.isLoggedIn()) {
    //         if (localStorage.getItem('jwt') == "" || undefined || null) {
    //             let url = '/admin/auth/login';
    //             window.location.href = url;
    //         }

    //         check();
    //     }
    // }


</script>
</html>
