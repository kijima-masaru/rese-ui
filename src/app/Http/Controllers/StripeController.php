<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// stripeの決済機能用のインポート
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function pay(Request $request)
    {
        Stripe::setApiKey('sk_test_51NjMYZHuosYE03bl4HVIfgB3xpYUhte3Oe1gjMAj4Al7qFFohmIIWvIdNj5kSP8AR5M96L5njVGjNO8YIxg3mmoO00kgEWRpDz');//シークレットキー
        $charge = Charge::create(array(
            'amount' => 100,
            'currency' => 'jpy',
            'source'=> request()->stripeToken,
        ));

        return view('thanks');
    }
}
