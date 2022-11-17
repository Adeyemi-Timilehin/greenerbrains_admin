@extends('layouts.auth')
@section('title')
Login - Signup
@endsection

@section('content')
<!--login-column  -->
<div class="login-column">
  <div class="login-column_header">
    <h4>
    <a href="{{ route('index') }}" style="color: inherit;">
      <strong>
        {{ config('app.name') }}
      </strong>
    </a>
    </h4>
    {{-- <img src="front/images/logo3.png" alt=""> --}}
    <div class="clearfix"></div>
  <h4>Welcome to {{ config('app.name', 'GreenerBrains') }}</h4>
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
  <div class="main-register-holder tabs-act">
    <div class="main-register fl-wrap">
      <ul class="tabs-menu fl-wrap no-list-style">
        @if (config('app.login'))
          <li class="{{ $mode === 'login' ? 'current' : '' }}" ><a href="#tab-1"><i class="fal fa-sign-in-alt"></i> Login</a></li>
        @endif
        <!--@if (config('app.signup'))-->
        <!--<li class="{{ $mode === 'register' ? 'current' : '' }}""><a href="#tab-2"><i class="fal fa-user-plus"></i> Register</a></li>-->
        <!--@endif-->
      </ul>
      <!--tabs -->
      <div class="tabs-container">
        <div class="tab">
          @if (config('app.login'))
          <!--tab -->
          <div id="tab-1" class="tab-content first-tab" style="{{ $mode !== 'login' ? 'display: none;' : '' }}">
            <div class="custom-form">
              <form method="post" name="registerform" action="{{ route('login') }}">
                @csrf
                <label>{{ __('Email') }} <span>*</span> </label>
                <input name="email" type="text" onClick="this.select()" value="">
                @if  ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
                
                <label>{{ __('Password') }} <span>*</span> </label>
                <input name="password" type="password" onClick="this.select()" value="">
                @if  ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
                
                <button type="submit" class="btn float-btn color2-bg"> Log In <i
                    class="fas fa-caret-right"></i></button>
                <div class="clearfix"></div>
                <div class="filter-tags">
                  <input id="check-a3" type="checkbox" name="remember">
                  <label for="check-a3">{{ __('Remember me') }}</label>
                </div>
              </form>
              <div class="lost_password">
                <a href="#" class="show-lpt">{{ __('Lost Your Password?') }}</a>
                <div class="lost-password-tootip">
                  <p>{{ __('Enter your email and we will send you a password') }}</p>
                  <input name="email" type="text" onClick="this.select()" value="">
                  <button type="submit" class="btn float-btn color2-bg"> Send<i class="fas fa-caret-right"></i></button>
                  <div class="close-lpt"><i class="far fa-times"></i></div>
                </div>
              </div>
            </div>
          </div>
          <!--tab end -->
          @endif



          <!--@if (config('app.signup'))-->
          <!--tab -->
          <!--<div class="tab">-->
          <!--  <div id="tab-2" class="tab-content" style="{{ $mode !== 'register' ? 'display: none' : 'display:block;' }}">-->
          <!--    <div class="custom-form">-->
          <!--      <form method="post" action="{{ route('register') }}" name="registerform" class="main-register-form" id="main-register-form2">-->
          <!--        @csrf-->
          <!--        <label>{{ __('Full Name') }} <span>*</span> </label>-->
          <!--        <input name="name" type="text" onClick="this.select()" value="">-->
          <!--        @if  ($errors->has('name'))-->
          <!--        <span class="invalid-feedback" role="alert">-->
          <!--            <strong>{{ $errors->first('name') }}</strong>-->
          <!--        </span>-->
          <!--        @endif-->

          <!--        <label>{{ __('Email Address') }} <span>*</span></label>-->
          <!--        <input name="email" type="text" onClick="this.select()" value="">-->
          <!--        @if  ($errors->has('email'))-->
          <!--        <span class="invalid-feedback" role="alert">-->
          <!--            <strong>{{ $errors->first('email') }}</strong>-->
          <!--        </span>-->
          <!--        @endif-->
                  
          <!--        <label>{{ __('Password') }} <span>*</span></label>-->
          <!--        <input name="password" type="password" onClick="this.select()" value="">-->
          <!--        @if  ($errors->has('password'))-->
          <!--        <span class="invalid-feedback" role="alert">-->
          <!--            <strong>{{ $errors->first('password') }}</strong>-->
          <!--        </span>-->
          <!--        @endif-->

          <!--        <label>{{ __('Confirm Password') }} <span>*</span></label>-->
          <!--        <input name="password_confirmation" type="password" onClick="this.select()" value="">-->
          <!--        @if  ($errors->has('password_confirmation'))-->
          <!--        <span class="invalid-feedback" role="alert">-->
          <!--            <strong>{{ $errors->first('password_confirmation') }}</strong>-->
          <!--        </span>-->
          <!--        @endif-->

          <!--        <div class="filter-tags ft-list">-->
          <!--          <input id="check-a2" type="checkbox" name="check">-->
          <!--          <label for="check-a2">I agree to the <a href="http://www.greenerbrains.com/privacy_policy">Privacy Policy</a></label>-->
          <!--        </div>-->
          <!--        <div class="clearfix"></div>-->
          <!--        <div class="filter-tags ft-list">-->
          <!--          <input id="check-a" type="checkbox" name="check">-->
          <!--          <label for="check-a">I agree to the <a href="http://www.greenerbrains.com/terms_of_use">Terms and Conditions</a></label>-->
          <!--        </div>-->
          <!--        <div class="clearfix"></div>-->
          <!--        <button type="submit" class="btn float-btn color2-bg"> Register <i-->
          <!--            class="fas fa-caret-right"></i></button>-->
          <!--      </form>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>-->
          <!--tab end -->
          <!--@endif-->
        </div>
        <!--tabs end -->
        {{-- <div class="log-separator fl-wrap"><span>or</span></div>
        <div class="soc-log fl-wrap">
          <p>For faster login or register use your social account.</p>
          <a href="#" class="facebook-log"> Facebook</a>
        </div> --}}
      </div>
    </div>
  </div>
</div>
<!--login-column end-->
<!--login-column-bg  -->
<div class="login-column-bg gradient-bg">
  <!--ms-container-->
  <div class="slideshow-container" data-scrollax="properties: { translateY: '300px' }">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <!--ms_item-->
        <div class="swiper-slide">
          <div class="ms-item_fs fl-wrap full-height">
            <div class="bg" data-bg="front/images/gb/little-green.jpeg"></div>
            <div class="overlay op7"></div>
          </div>
        </div>
        <!--ms_item end-->
        <!--ms_item-->
        {{-- <div class="swiper-slide ">
          <div class="ms-item_fs fl-wrap full-height">
            <div class="bg" data-bg="front/images/bg/13.jpg"></div>
            <div class="overlay op7"></div>
          </div>
        </div> --}}
        <!--ms_item end-->
        <!--ms_item-->
        {{-- <div class="swiper-slide">
          <div class="ms-item_fs fl-wrap full-height">
            <div class="bg" data-bg="front/images/bg/35.jpg"></div>
            <div class="overlay op7"></div>
          </div>
        </div> --}}
        <!--ms_item end-->
      </div>
    </div>
  </div>
  <!--ms-container end-->
  <div class="login-promo-container">
    <div class="container">
      <div class="video_section-title fl-wrap">
        <h4>Learn & Lead</h4>
        <h2>{{ config('app.name') }} <br>Admin Dashboard
        </h2>
      </div>
      {{-- <a href="../vimeo.com/253953667.html" class="promo-link big_prom   image-popup"><i
          class="fal fa-play"></i><span>Promo Video</span></a> --}}
    </div>
  </div>
</div>
<!--login-column-bg end-->
@endsection