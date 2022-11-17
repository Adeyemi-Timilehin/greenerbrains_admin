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
            name="{{ config('app.description') }}"
            content="{{ config('app.name') }} Mobile Dashboard."
        />
        <meta name="author" content="greenerbrains" />

        <title>{{ config('app.name') }} Password Change</title>

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
                    <h4><a href="/">{{ config('app.name') }}</a></h4>
                    <p class="mg-b-0">{{ trans('Password Change') }}</p>
                    <p
                        class="mg-b-0"
                        style="color: red;"
                        id="error-submission"
                    ></p>
                    <p
                        class="mg-b-0 hidden"
                        style="color: red;"
                        id="error-password-mismatch"
                    >
                    {{ trans('Passwords mismatch!') }}
                    </p>

                    @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    {{-- <div class="alert alert-primary" role="alert">
                      {{ isset($message) ? $message : '' }}
                    </div> --}}
                    @endif
                    @if(Session::has('error'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
                    @endif
                </div>
                <!-- signbox-header -->
                <div class="signbox-body">
                <form id="reset-password-form" method="POST" action="{{ route('change-password') }}">
                  @csrf
                        <div class="form-group">
                            <label class="form-control-label">{{ trans('Old Password:') }}</label>
                            <input
                                type="password"
                                name="old_password"
                                id="old_password"
                                placeholder="Enter your old password"
                                class="form-control"
                            />
                            @if  ($errors->has('old_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <hr>
                        <!-- form-group -->
                        <div class="form-group">
                            <label class="form-control-label">{{ trans('New Password:') }}</label>
                            <input
                                type="password"
                                name="new_password"
                                id="new_password"
                                placeholder="Enter new password"
                                class="form-control"
                            />
                            @if  ($errors->has('new_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('new_password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <!-- form-group -->
                        <!-- col -->
                        <div class="form-group">
                            <label class="form-control-label">{{ trans('Confirm Password:') }}</label>
                            <input
                                type="password"
                                name="new_confirm_password"
                                id="new_confirm_password"
                                class="form-control"
                                placeholder="Retype new password"
                            />
                            @if  ($errors->has('new_confirm_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('new_confirm_password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <!-- form-group -->
                        <button type="submit" class="btn btn-dark btn-block button"> {{ trans('Continue') }}</button>
                        
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
        {{-- <script src="{{ asset('js/api.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/change-password.js') }}"></script> --}}
    </body>
</html>
