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
        $minDonation = config('paypal.min_donation');
        $validator = Validator::make($input, [
          'amount' => "required|integer|min:{$minDonation}",
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Donation to Greenerbrains");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('https://greenerbrains.com/donation/success')
            ->setCancelUrl('https://greenerbrains.com/donation/cancel');

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
