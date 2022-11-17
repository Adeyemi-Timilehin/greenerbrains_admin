<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Traits\EmailTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ResetPasswordController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

  use ResetsPasswords, EmailTrait;

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  public function showResetForm(Request $request, $token = null)
  {
    if (!Auth::check()) return redirect()->back();
    return view('auth.reset-password')->with(
      ['token' => Str::random(60), 'email' => Auth::user()->email]
    );
  }

  protected function resetPassword($user, $password)
  {
    $this->setUserPassword($user, $password);

    $user->setRememberToken(Str::random(60));

    $user->save();

    $this->guard()->login($user);
    return true;
  }


  public function sendResetEmail($email, $password)
  {
      //Retrieve the user from the database
      $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
      if (
          $this->customSendEmail([
              "to_email" => $email,
              "to_name" => $user->name,
              "from_name" => Config::get('mail.from.name'),
              "from_email" => Config::get('mail.from.address'),
              "subject" => "Password Reset",
              "body" => $password
          ], "reset-password")
      ) {
          return true;
      }
      return false;
  }


  public function reset(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|confirmed|min:8',
    ]);

    // validate inputs
    if ($validator->fails()) {
      Session::flash('errors', $validator->errors());
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    }

    // $request->validate($this->rules(), $this->validationErrorMessages());

    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    
    $user = User::where('id', $request->user()->id)->first();
    if (isset($user) && isset($request->password)) {
      $response = $this->resetPassword($user, $request->password);
      if ($response) {
        Session::flash('message', 'Password reset successful!');
        return redirect()->back()->with('success', 'Password reset successful!');
      } else {
        Session::flash('error', 'Password reset not successful!');
        return redirect()->back()->with('error', 'Password reset not successful!');
      }
    } else {
      Session::flash('error', 'User not found!... There might be something wrong as this problem does not occur often');
      return redirect()->back()->with('error', 'User not found!... <br>There might be something wrong as this problem does not occur often');
    }
    
  }
}
