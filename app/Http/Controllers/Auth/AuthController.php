<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\UserResource;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Traits\EmailTrait;

class AuthController extends BaseController
{
  use EmailTrait;

  public function register(Request $request)
  {
    if (!isset($request->name)) {
      return $this->sendError("Name field is required!", [], $code = 400);
    }
    if (!isset($request->email)) {
      return $this->sendError("Email field is required!", [], $code = 400);
    }
    if (!isset($request->password)) {
      return $this->sendError("Password field is required!", [], $code = 400);
    }

    // Check for duplicate account!
    $u = User::where("email", $request->email)->first();
    if ($u) {
      return $this->sendError("Email already signed up!", [], $code = 400);
      return;
    }

    // Spaghetti code to be refactored later
    if (isset($request->user_type)) {
      if ($request->user_type == "admin") {
        if (count(User::where("type", "admin")->get()) > 0) {

          $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->user_type,
            'password' => bcrypt($request->password),
            'status' => "unactivated"
          ]);

          // Attach default role if role was not specified
          if (!isset($request->type)) $request->type = 'user';
          $user_role = $request->type ? Role::where('name', $request->type)->first() : Role::where('name', 'user')->first();
          if ($user_role) {
            $user->roles()->attach($user_role->id);
          }
        } else {
          $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->user_type,
            'password' => bcrypt($request->password),
            'status' => "active"
          ]);

          // Attach default role if role was not specified
          if (!isset($request->type)) $request->type = 'user';
          $user_role = $request->type ? Role::where('name', $request->type)->first() : Role::where('name', 'user')->first();
          if ($user_role) {
            $user->roles()->attach($user_role->id);
          }
        }
      } else if ($request->user_type == "user") {
        $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'type' => $request->user_type,
          'password' => bcrypt($request->password),
          'status' => "active"
        ]);

        // Attach default role if role was not specified
        if (!isset($request->type)) $request->type = 'user';
        $user_role = $request->type ? Role::where('name', $request->type)->first() : Role::where('name', 'user')->first();
        if ($user_role) {
          $user->roles()->attach($user_role->id);
        }
      } else {
        return $this->sendError("Invalid parameter value identitfied!", [], $code = 402);
      }
    } else {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'type' => "user",
        'password' => bcrypt($request->password),
        'status' => "active"
      ]);

      // Attach default role if role was not specified
      if (!isset($request->type)) $request->type = 'user';
      $user_role = $request->type ? Role::where('name', $request->type)->first() : Role::where('name', 'user')->first();
      if ($user_role) {
        $user->roles()->attach($user_role->id);
      }
    }




    if (isset($user->email)) {
      $this->sendRegistrationEmail($user->email);
    }

    if (!$token = auth()->attempt($request->only(['email', 'password']))) {
      return $this->sendError("Authentication error", [], $code = 401);
    }

    return (new UserResource($user))
      ->additional([
        'meta' => [
          "status" => "success",
          "message" => "User registration successfull",
          'token' => $token
        ]
      ]);
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

  public function login(Request $request)
  {
    if (!isset($request->email)) {
      return $this->sendError("Email field is required!", [], $code = 400);
    }
    if (!isset($request->password)) {
      return $this->sendError("Password field is required!", [], $code = 400);
    }

    if (!$token = auth()->attempt($request->only(['email', 'password']))) {

      return $this->sendError("Error verifying details!", null,  $code = 422);
    }

    if ($request->user()->status !== "active") {
      return $this->sendError("Account unactivated!", null,  $code = 401);
    }

    return (new UserResource($request->user()))
      ->additional([
        "status" => "success",
        "message" => "Login successful",
        'meta' => [
          'token' => $token
        ]
      ]);
  }

  public function user(Request $request)
  {
    if ($request->user()) {
      $user = User::where('id', '=', $request->user()->id)->with(['subscribed_subjects', 'notebooks'])->first();
      return (new UserResource($user))->additional([
        "status" => "success",
        "message" => "successful"
      ]);
    }
    return $this->sendError("Authentication error", [], $code = 401);
  }

  public function logout()
  {
    auth()->logout();
    return $this->sendResponse(null, "Logout successful");
  }
}
