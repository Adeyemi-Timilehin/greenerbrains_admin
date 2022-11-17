<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Payment;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\UserSubject;
use App\Traits\EmailTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Subject;
use App\User;

class PaymentController extends Controller
{

  use EmailTrait;


  // API based paystack transaction verifier
  public function verifyPaystackTransaction(Request $request)
  {
    //check if request was made with the right data
    if (!isset($request->reference)) {
      return response()->json("Transaction reference not found", 400);
    }

    //set reference to a variable @ref
    $reference = $request->reference;

    try {
      //The parameter after verify/ is the transaction reference to be verified
      $url = 'https://api.paystack.co/transaction/verify/' . $reference;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        [
          'Authorization: Bearer ' . config('paystack.secretKey')
        ]
      );

      //send request
      $request_r = curl_exec($ch);
      //close connection
      curl_close($ch);
      //declare an array that will contain the result 
      $result = array();

      if ($request_r) {
        $result = json_decode($request_r, true);
      }

      if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
        return response()->json("Valid transaction!", 200);
        //Perform necessary action
      } else {
        return response()->json("Invalid transaction", 406);
      }
    } catch (\Throwable $th) {
      return response()->json($th);
    }
  }


  // Verify paystack payment internally
  private function verifyPaystack(Request $request)
  {
    //check if request was made with the right data
    if (!isset($request->reference)) {
      return response()->json("Transaction reference not found", 400);
    }

    //set reference to a variable @ref
    $reference = $request->reference;

    try {
      //The parameter after verify/ is the transaction reference to be verified
      $url = 'https://api.paystack.co/transaction/verify/' . $reference;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        [
          'Authorization: Bearer ' . config('paystack.secretKey')
        ]
      );

      //send request
      $request_r = curl_exec($ch);
      //close connection
      curl_close($ch);
      //declare an array that will contain the result 
      $result = array();

      if ($request_r) {
        $result = json_decode($request_r, true);
      }

      if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
        return $result['data'];
        //Perform necessary action
      } else {
        return null;
      }
    } catch (\Throwable $th) {
      return null;
    }
  }



  // Process Entry Point
  public function terminal(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($input, [
      'subject_id' => 'required|string',
      'user_id' => 'required',
      'reference' => 'required|string'
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 403)
        ->withErrors($validator->errors())
        ->withInput($request->all());
    }

    // verify user
    if (!$this->verifyUser($request->user_id)) {
      return response()->json('User account not found!', 404);
    }


    // verify paystack transaction
    $paystackData = $this->verifyPaystack(new Request(['reference' => $request->reference]));
    if (!isset($paystackData)) {
      return response()->json('Invalid transaction details!', 404);
    }


    // process payment
    $prData = new Request($paystackData);
    $prData['subject_id'] = $request->subject_id;
    $prData['user_id'] = $request->user_id;
    if ($this->paymentProcessor($prData)) {
      return response()->json('Payment completed', 200);
    } else {
      return response()->json('Payment Unsuccessfull!', 403);
    }
  }


  // Payment processing unit
  public function paymentProcessor(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($input, [
      'subject_id' => 'required|string',
      'user_id' => 'required',
      'payment_id' => 'required|string',
      'status' => 'required|string',
      'reference' => 'required|string',
      'channel' => 'required|string',
      'currency' => 'required|string',
      'amount' => 'required|number',
      'domain' => 'string|required',
      'paid_at' => 'string'
    ]);

    if ($validator->fails()) {
      return false;
      return response()->json($validator->errors(), 403)
        ->withErrors($validator->errors())
        ->withInput($request->all());
    }


    // backup logic for when there's no request
    $subject = $this->verifySubject($request->subject_id);
    if (isset($subject) && isset($subject->access)) {
      $request['payment_status'] = $subject->access === 'free' ? 'verified' : 'unverified';
    }


    // Check for duplicate
    if ($this->isDuplicateSubscription($request->user_id, $request->subject_id)) {
      return false;
      return response()->json("You have already subscribed to this course!", 400);
    }


    if (!$subject) {
      return false;
      return response()->json("The system can't seem to identify the subject specified!", 404);
    }

    $input['id'] = uniqid("gb", false);
    if (isset($subject)) {
      // Set variable to determine if subject is free or paid
      $subject_access_status = $subject->access;

      // Subscribe for paid subject
      if ($subject_access_status !== 'free') {
        // process course purchase
        try {
          if (!$this->addToPayment($request) || !$this->addToSubscription($request)) {
            Log::channel('subscription')->error('Failed to add record subscription | payment during a Payment process');
            return false;
            return response()->json('System failed to record new subscription and payment!', 500);
          }

          if ($this->sendSubscriptionEmail($request->user_id, $subject->label)) {;
            Log::channel('subscription')->info('Subscription email sent after Payment process');
          } else {
            Log::channel('subscription')->error('Failed to send subscription email after a Payment process');
          }

          return response()->json("Subscription completed Successfully!", 200);
        } catch (\Exception $e) {
          Log::channel('subscription')->error('Payment subscription failed');
          return false;
        }
      } else {
        return false;
        return response()->json('Sorry, there was a problem while trying to subscribe you for this course! Kindly try again or contact admin if it persist', 500);
      }
    } else {
      return false;
      return response()->json('Course not found in courses list!', 404);
    }
    return false;
    return response()->json('Subscription Failed!', 500);
  }



  public function addToSubscription(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($request->all(), [
      'subject_id' => 'required|string',
      'user_id' => 'required',
      'status' => 'required|string'
    ]);

    if ($validator->fails()) {
      Log::channel('subscription')->error('Request validation failed at subscription during a Payment process');
      return false;
      return response()->json($validator->errors(), 403)
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {

      try {
        $user_sub = UserSubject::create([
          'id' => uniqid("gb", false),
          'user_id' => $input['user_id'],
          'subject_id' => $input['subject_id'],
          'status' => 'paid'
        ]);
        return $user_sub;
      } catch (\Throwable $th) {
        Log::channel('subscription')->error('Failed to add new subscription during a Payment process');
        return false;
      }
    }
  }


  public function addToPayment(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'subject_id' => 'required|string',
      'user_id' => 'required',
      'payment_id' => 'required|string',
      'status' => 'required|string',
      'reference' => 'required|string',
      'channel' => 'required|string',
      'currency' => 'required|string',
      'amount' => 'required|number',
      'domain' => 'string|required',
      'paid_at' => 'string'
    ]);

    if ($validator->fails()) {
      Log::channel('subscription')->error('Request validation failed at payment during a Payment process');
      return response()->json($validator->errors(), 403)
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {
        $payment =  Payment::create([
          'subject_id' => $request['subject_id'],
          'user_id' => $request['user_id'],
          'payment_id' => $request['payment_id'],
          'status' => $request['status'],
          'reference' => $request['reference'],
          'channel' => $request['channel'],
          'currency' => $request['currency'],
          'amount' => $request['amount'],
          'domain' => $request['domain'],
          'paid_at' => $request['paid_at'],
        ]);
        return $payment;
      } catch (\Throwable $th) {
        Log::channel('subscription')->error('Failed to add new Payment during a Payment process');
        return false;
        return response()->json("Failed to register payments", 500);
      }
    }
  }



  private function verifyUser($user_id = null)
  {
    if (isset($user_id) && $user_id !== '') {
      $user = User::where('id', $user_id)->first();
      if (isset($user)) {
        return $user;
      } else {
        return null;
      }
    } else {
      return null;
    }
  }



  private function verifySubject($subject_id = null)
  {
    if (isset($user_id) && $user_id !== '') {
      $subject = Subject::with(['access', 'categories', 'contents'])->where('id', $subject_id)->first();
      if (isset($subject)) {
        return $subject;
      } else {
        return null;
      }
    } else {
      return null;
    }
  }


  private function isDuplicateSubscription($user_id = null, $subject_id = null)
  {
    if (!isset($user_id) || !isset($subject_id)) return null;

    $duplicate = UserSubject::with('subject')->where([['user_id', $user_id], ['subject_id', $subject_id]])->first();
    if (!is_null($duplicate)) {
      return $duplicate;
    } else {
      return null;
    }
  }

  public function sendSubscriptionEmail($user_id, $courseName)
  {
    //Retrieve the user from the database
    $user = User::where('id', $user_id)->select('name', 'email')->first();

    //Here send the link with CURL with an external email API
    if (
      $this->customSendEmail([
        "to_email" => $user->email,
        "to_name" => $user->name,
        "from_name" => Config::get('mail.from.name'),
        "from_email" => Config::get('mail.from.address'),
        "subject" => "Subscription",
        "body" => $courseName
      ], "subscription")
    ) {
      return true;
    }
    return false;
  }




  /**
   * Responds with a welcome message with instructions
   *
   * @return \Illuminate\Http\Response
   */
  public function error()
  {
    return response()->json((isset($message) && $message !== '' ? $message : 'Payment process failed.'), 400);
  }



  /**
   * Responds with a welcome message with instructions
   *
   * @return \Illuminate\Http\Response
   */
  public function cancel($message = null)
  {
    return response()->json((isset($message) && $message !== '' ? $message : 'Your payment is cancelled.'), 200);
  }


  /**
   * Responds with a welcome message with instructions
   *
   * @return \Illuminate\Http\Response
   */
  public function success($message = null)
  {
    return response()->json((isset($message) && $message !== '' ? $message : 'Your payment was successfully. You can create success page here.'), 200);
  }
}
