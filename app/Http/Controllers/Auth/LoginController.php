<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  // protected $redirectTo = RouteServiceProvider::HOME;
  protected $redirectTo = '/dashboard';
  // 

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }




  public function showLoginForm()
  {
    if (!Auth::check()) {
      session(['link' => url()->previous()]);
      return view('auth.login-register')->with('mode', 'login');
    } else {
      return url()->previous();
    }
  }

  protected function redirectTo()
  {
    return url()->previous();
  }

  protected function authenticated(Request $request, $user)
  {
    if (url()->previous() !== '') {
      return redirect(url()->previous());
    } else {
      return route('dashboard');
    }
  }



  /**
   * Handle a login request to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  // public function login(Request $request)
  // {
  //   $validator = Validator::make($request->all(), [
  //     'email' => ['required', 'string', 'email'],
  //     'password' => ['required', 'string', 'min:8']
  //   ]);

  //   if ($validator->fails()) {
  //     return back()
  //       ->withErrors($validator->errors())
  //       ->withInput($request->all());
  //   }

  //   // If the class is using the ThrottlesLogins trait, we can automatically throttle
  //   // the login attempts for this application. We'll key this by the username and
  //   // the IP address of the client making these requests into this application.
  //   if ($this->hasTooManyLoginAttempts($request)) {
  //     $this->fireLockoutEvent($request);

  //     return $this->sendLockoutResponse($request);
  //   }


  //   if ($this->attemptLogin($request)) {
  //     // dd($this->sendLoginResponse($request));
  //     return $this->sendLoginResponse($request);
  //   }

  //   // If the login attempt was unsuccessful we will increment the number of attempts
  //   // to login and redirect the user back to the login form. Of course, when this
  //   // user surpasses their maximum number of attempts they will get locked out.
  //   $this->incrementLoginAttempts($request);

  //   return $this->sendFailedLoginResponse($request);
  // }

  /**
   * Attempt to log the user into the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return bool
   */
  protected function attemptLogin(Request $request)
  {
    return $this->guard()->attempt($this->credentials($request), $request->filled('remember'));
  }

  /**
   * Get the needed authorization credentials from the request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  protected function credentials(Request $request)
  {
    return $request->only('email', 'password');
  }


  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => ['required', 'string', 'email'],
      'password' => ['required', 'string', 'min:8']
    ]);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    }

    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    // the login attempts for this application. We'll key this by the username and
    // the IP address of the client making these requests into this application.
    if ($this->hasTooManyLoginAttempts($request)) {
      $this->fireLockoutEvent($request);

      return $this->sendLockoutResponse($request);
    }

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      // Authentication passed...
      return redirect()->intended($this->redirectPath());
      // return redirect()->route('dashboard');
      // return $this->authenticated($request, Auth::user());
      // return redirect()->intended('dashboard');
    }
  }
}
