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

    public function pay(Request $request){
        Stripe::setApiKey('pk_test_51NjMYZHuosYE03blXTaFQPxuno5yZsJcyjw9F4x8jXwK7SgnWJHOD52SGcoRnLG8CJQPsPkchciE4EI5EjliMojw00o8XjGnDm');//シークレットキー
        $charge = Charge::create(array(
            'amount' => 100,
            'currency' => 'jpy',
            'source'=> request()->stripeToken,
        ));

        return back();
    }
}
