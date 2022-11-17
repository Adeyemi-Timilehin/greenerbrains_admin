<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

/** Paypal Details classes **/

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use App\Subject;
use App\Payment as AppPayment;
use Illuminate\Support\Facades\Validator;
use App\Traits\EmailTrait;

class PayPalController extends BaseController
{
    use EmailTrait;

    /**
     * @var \PayPal\Rest\ApiContext
     */
    protected $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(config('paypal.client_id'), config('paypal.client_secret'))
        );

        $this->apiContext->setConfig(config('paypal.settings'));
    }

    /**
     * Handle payments for course subscription.
     */
    public function handle(Request $request)
    {
        // validate request input
        $input = $request->all();
        $validator = Validator::make($input, [
          'subject_id' => 'required|string|exists:subjects,id',
          'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $subject = Subject::find($input['subject_id']);

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($subject->price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Subscription for $subject->label course.");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('https://greenerbrains.com/payment/complete')
            ->setCancelUrl('https://greenerbrains.com/payment/cancel');

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->sendError('Request timed out', [], 500);
        }

        // we store the payment to the database
        AppPayment::create([
            'subject_id' => $request['subject_id'],
            'user_id' => $request['user_id'],
            'payment_id' => $payment->getId(),
            'reference' => uniqid('gb-'),
            'status' => $payment->getState(), // created, approved, failed
            'channel' => 'paypal',
            'currency' => 'USD',
            'amount' => $subject->price,
            'domain' => 'paypal.com',
        ]);

        $redirect = null;

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() === 'approval_url') {
                $redirect = $link->getHref();
            }
        }

        if (! $redirect) {
            return $this->sendError('An unknown error occured', [], 500);
        }

        return response()->json([
            'redirect' => $redirect
        ], 200);
    }
}
