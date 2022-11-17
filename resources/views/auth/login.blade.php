<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />


        <!-- Meta -->
        <meta
            name="description"
            content="Greener Brains Mobile Dashboard."
        />
        <meta name="author" content="greenerbrains" />

        <title>Greener Brains Mobile Dashboard</title>

        <!-- vendor css -->
        <link
            href="{{ asset('lib/font-awesome/css/font-awesome.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('lib/Ionicons/css/ionicons.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset('lib/perfect-scrollbar/css/perfect-scrollbar.css')
            }}"
            rel="stylesheet"
        />

        <!-- magen-iot-admin CSS -->
        <link rel="stylesheet" href="{{ asset('css/magen-iot-admin.css') }}" />
        <style>
            a {
                text-decoration: none !important;
                text-transform: none;
                color: inherit;
            }
            a:hover {
                text-decoration: none !important;
                text-transform: none;
                color: inherit;
            }
        </style>
    </head>

    <body>
        <div class="signpanel-wrapper">
            <div class="signbox">
                <div class="signbox-header">
                    <h4><a href="/">GreenerBrains</a></h4>
                    <p class="mg-b-0">Admin Login</p>
                    <p
                        class="mg-b-0"
                        style="color: red;"
                        id="error-submission"
                    ></p>
                </div>
                <!-- signbox-header -->
                <div class="signbox-body">
                    <form id="login-form">
                        <div class="form-group">
                            <label class="form-control-label">Email:</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="Enter your email"
                                class="form-control"
                            />
                        </div>
                        <!-- form-group -->
                        <div class="form-group">
                            <label class="form-control-label">Password:</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Enter your password"
                                class="form-control"
                            />
                        </div>
                        <!-- form-group -->
                        <div class="form-group">
                            <a href="/admin/auth/reset-password">Forgot password?</a>
                        </div>
                        <!-- form-group -->
                        <button class="btn btn-dark btn-block button">Sign In</button>
                        <div class="tx-center bd pd-10 mg-t-40">
                            Not yet a member?
                            <a href="/admin/auth/register">Create an account</a>
                        </div>
                    </form>
                </div>
                <!-- signbox-body -->
            </div>
            <!-- signbox -->
        </div>
        <!-- signpanel-wrapper -->

        <script src="{{ asset('lib/jquery/jquery.js') }}"></script>
        <script src="{{ asset('lib/popper.js/popper.js') }}"></script>
        <script src="{{ asset('lib/bootstrap/bootstrap.js') }}"></script>
        <script src="{{ asset('js/api.js') }}"></script>
        <script src="{{ asset('js/login.js') }}"></script>
    </body>
</html>
