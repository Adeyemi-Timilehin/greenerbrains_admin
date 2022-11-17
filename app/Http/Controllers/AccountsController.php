<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\User;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\DB;
use App\Traits\EmailTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;

class AccountsController extends BaseController
{
    use EmailTrait;

    public function resetPasswordRequest(Request $request)
    {
        // You can add validation login here
        $user = User::where('email', '=', $request->email)->first();

        //Check if the user exists
        if (!isset($user)) {
            return $this->sendError(trans('Account not found!'), [], $code = 400);
        }

        if($user->status !== "active"){
            return $this->sendError("Unactivated account!", null,  $code = 401);
        }

        //Generate new password for user
        $new_password = Str::limit(Str::uuid(), $length = 8, "");

        try {
          // change user password
          $user->password = bcrypt($new_password);
          $user->save();
          
          if ($this->sendResetEmail($request->email, $new_password)) {
              return $this->sendResponse(null, trans('A new password has been sent to your email address.'));
          } else {
              return $this->sendError(trans('An error occured while sending new password, please try again or contact admin if problem persist!'), [], $code = 500);
          }
        } catch (\Exception $e) {
            return $this->sendError(trans("Error sending your new password, please try again or contact admin if problem persist!"), [], $code = 500);
        }
    }


    public function updateProfile(Request $request, $id)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'email|exists:users,email',
            'name' => 'string',
            'status' => 'string'
        ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return $this->sendError(trans("Invalid form inputs"), [], $code = 400);
        }

        // You can add validation login here
        $user = User::where('id', '=', $request->user()->id)->first();

        //Check if the user exists
        if (count($user) < 1) {
            return $this->sendError(trans('User does not exist'), [], $code = 400);
        }

        if ($request->password) {
            unset($request->password);
        }

        if ($user->update($request->all())) {
            return $this->sendResponse($user, trans('User profile updated successfully'));
        } else {
            return $this->sendError(trans('Unsuccessful, try again.'), [], $code = 400);
        }
    }












    public function sendResetEmail($email, $password)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
        // try {
        //Here send the link with CURL with an external email API
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
        // } catch (\Exception $e) {
        //     // return response($e);
        //     // return $this->sendError($e, [], $code = 400);
        //     // return false;
        // }
    }











    public function resetPassword(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return $this->sendError(trans("Invalid form inputs"), ['email' => 'Please complete the form'], $code = 400);
            // return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;

        // Validate the token
        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();

        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) {
            return $this->sendError(trans("No request has been made for password reset!"), [], $code = 400);
            // return view('auth.passwords.email');
        }

        $user = User::where('email', $tokenData->email)->first();

        // Redirect the user back if the email is invalid
        if (!$user) {
            return $this->sendError(trans("Email not found"), [], $code = 400);
            // return redirect()->back()->withErrors(['email' => 'Email not found']);
        }

        // Check if account has been activated!
        if($user->status !== "active"){
            return $this->sendError("Unactivated account!", null,  $code = 401);
        }

        //Hash and update the new password
        $user->password = bcrypt($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        // Auth::login($user);
        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return $this->sendError(trans("Login attempt failed!"), [], $code = 400);
            // return redirect()->back()->withErrors(['email' => 'Login attempt failed!']);
        }

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)->delete();

        //Send Email Reset Success Email
        if ($this->sendSuccessEmail($tokenData->email)) {
            return $this->sendResponse(null, "Reset successful");
            // $contents = Content::all();
            // return view("pages.content.index")->with('contents', $contents);
        } else {
            return $this->sendError(trans("A Network Error occurred. Please try again."), [], $code = 500);
            // return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }
    }











    public function changePassword(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|exists:users,email',
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required',
        ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return $this->sendError(trans("Invalid inputs"), $validator->errors(), $code = 400);
        }
        if ($request->new_password !== $request->confirm_new_password) {
            return $this->sendError(trans("New inputed passwords do not match!"), null, $code = 400);
        }

        if ($request->user()) {
            // return response()->json([bcrypt($request->old_password)]);
            $user = User::where('email', $request->user()->email);
            isset($user) ? $user = $user->first() : $user = null;

            // Redirect the user back if the email is invalid
            if (!$user) {
                return $this->sendError(trans("Credentials not found"), [], $code = 400);
            }

            // Check password match
            if (\Hash::check($request->old_password, $request->user()->password) !== true) {
                return $this->sendError(trans("Credentials do not match"), [], $code = 400);
            }

            //Hash and update the new password
            $password = $request->new_password;
            $user->password = bcrypt($password);
            $user->update(); //or $user->save();

            //login the user immediately they change password successfully
            // Auth::login($user);
            if (!$token = auth()->attempt(["email" => $user->email, "password" => $request->new_password])) {
                return $this->sendError(trans("Password Reset Successful. Login attempt failed!"), [], $code = 400);
            } else {
                return (new UserResource($request->user()))
                    ->additional([
                        "status" => "success",
                        "message" => "successful",
                        'meta' => [
                            'token' => $token
                        ]
                    ]);
            }
        } else {
            return $this->sendError('You need to signin to perform this action!', []);
        }
    }
}
