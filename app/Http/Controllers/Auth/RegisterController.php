<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use App\Traits\EmailTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers, EmailTrait;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  // protected $redirectTo = RouteServiceProvider::HOME;
  protected $redirectTo = '/';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }


  public function showRegistrationForm()
  {
    if (!Auth::check()) {
      return view('auth.login-register')->with('mode', 'register');
    }
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  // protected function validator(array $data)
  // {
  //   return Validator::make($data, [
  //     'name' => ['required', 'string', 'min:5', 'max:255'],
  //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
  //     'password' => ['required', 'string', 'min:8', 'confirmed']
  //   ]);
  // }


  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => ['required', 'string', 'min:5', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed']
    ]);

    if ($validator->fails()) {
      // dd($validator->errors());
      return back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    }

    try {
      $user = [];

      $user['name'] = $request['name'];
      $user['email'] = $request['email'];
      $user['password'] = Hash::make($request['password']);
      $user['token'] = Hash::make($request['email']);

      $user_data = User::create($user);

      // Attach default role if role was not specified
      if (!isset($request['role'])) $request['role'] = 'user';
      $client_role = $request['role'] ? Role::where('name', $request['role'])->first() : Role::where('name', 'client')->first();
      if ($client_role) {
        $user_data->roles()->attach($client_role->id);
      }

      // Send Email
      if (isset($user_data->email)) {
        // $this->customSendEmail([
        //   "to_email" => $user_data->email,
        //   "to_name" => $user_data->name,
        //   "from_name" => Config::get('mail.from.name'),
        //   "from_email" => Config::get('mail.from.address'),
        //   "subject" => "Password Reset",
        //   "body" => $user_data->name . ' ' . $user_data->email
        // ], "registration");
        $this->sendRegistrationEmail($user_data->email);
      }

      $this->guard()->login($user_data);

      return $this->registered($request, $user_data) ?: redirect($this->redirectPath());

      // return $user_data;
    } catch (\Throwable $th) {
      Session::flash('error', 'Registration failed');
      return redirect()->back()->with('mode', 'register');
    }
  }


  public function sendRegistrationEmail($email)
  {
    //Retrieve the user from the database
    $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
    if (
      $this->customSendEmail([
        "to_email" => $user->email,
        "to_name" => $user->name,
        "from_name" => Config::get('mail.from.name'),
        "from_email" => Config::get('mail.from.address'),
        "subject" => "Account registration",
        "body" => $user
      ], "registration")
    ) {
      return true;
    }
    return false;
  }
}
