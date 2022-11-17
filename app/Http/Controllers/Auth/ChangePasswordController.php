<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;

class ChangePasswordController extends Controller
{
  /**

   * Create a new controller instance.
   *
   * @return void
   */

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showResetForm(Request $request, $token = null)
  {
    // if (!Auth::check() || !Auth::user()) {
    //   return redirect()->back();
    // }

    return view('auth.change-password')->with(
      ['token' => $token, 'email' => $request->email]
    );
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function index()
  {
    return view('auth.change-password');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'old_password' => ['required', new MatchOldPassword],
      'new_password' => ['required'],
      'new_confirm_password' => ['same:new_password'],
    ]);


    if ($validator->fails()) {
      return back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    }

    User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
    return redirect()->route('dashboard')->with('success', 'Password change successfull');
  }
}
