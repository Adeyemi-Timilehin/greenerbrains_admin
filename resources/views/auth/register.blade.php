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
        <meta name="description" content="Greener Brains Mobile Dashboard<" />
        <meta name="author" content="greenerbrains" />

        <title>Greener Brains Mobile Dashboard<</title>

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
            <div class="signbox signup">
                <div class="signbox-header">
                    <h4><a href="/">GreenerBrains</a></h4>
                    <p class="mg-b-0">Admin BackEnd</p>
                    <p
                        class="mg-b-0 hidden"
                        style="color: red;"
                        id="error-password-mismatch"
                    >
                        Passwords mismatch!
                    </p>
                    <p
                        class="mg-b-0 hidden"
                        style="color: red;"
                        id="error-submission"
                    >
                        Error submitting form!
                    </p>
                </div>

                <!-- signbox-header -->
                <div class="signbox-body">
                    <form id="regiter-form">
                        <div class="form-group">
                            <label class="form-control-label">Name:</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                placeholder="Name"
                                required
                            />
                            <input
                                class="hidden"
                                name="user-type"
                                id="user-type"
                                value="admin"
                                required
                            />
                        </div>
                        <!-- form-group -->
                        <div class="form-group">
                            <label class="form-control-label">Email:</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                placeholder="Email"
                                required
                            />
                        </div>
                        <!-- form-group -->

                        <div class="row row-xs">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label class="form-control-label"
                                        >Password:</label
                                    >
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control"
                                        placeholder="password"
                                        required
                                    />
                                </div>
                                <!-- form-group -->
                            </div>
                            <!-- col -->
                            <div class="col-sm">
                                <div class="form-group">
                                    <label class="form-control-label"
                                        >Confirm Password:</label
                                    >
                                    <input
                                        type="password"
                                        name="confirm-password"
                                        id="confirm-password"
                                        class="form-control"
                                        placeholder="Retype password"
                                    />
                                </div>
                                <!-- form-group -->
                            </div>
                            <!-- col -->
                        </div>
                        <!-- row -->

                        <div class="form-group mg-b-20 tx-12">
                            By clicking Sign Up button below you agree to our
                            <a href="#">Terms of Use</a> and our
                            <a href="#">Privacy Policy</a>
                        </div>

                        <button type="submit" class="btn btn-dark btn-block">
                            Sign Up
                        </button>
                        <div class="tx-center bd pd-10 mg-t-40">
                            Already a member?
                            <a href="/admin/auth/login">Sign In</a>
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
        <script src="{{ asset('js/createuser.js') }}"></script>
    </body>

</html>
