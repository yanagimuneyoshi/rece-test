<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentController extends Controller
{
  public function createPaymentIntent(Request $request)
  {
    try {
      Stripe::setApiKey(config('services.stripe.secret'));

      $paymentIntent = PaymentIntent::create([
        'amount' => $request->amount,
        'currency' => 'jpy',
        'payment_method_types' => ['card'],
      ]);

      return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}
