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
        if (request()->is('mypage/payment')) {
            // /mypage/paymentにアクセスされた場合
            return view('user_stripe');
        } elseif (request()->is('owner/payment')) {
            // /owner/chargeにアクセスされた場合
            return view('owner_stripe');
        }
    }

    public function createPayment(Request $request)
    {
        // StripeのAPIキーを設定
        Stripe::setApiKey(config('services.stripe.secret'));

        // Stripe.jsから受け取ったトークンを取得
        $token = $request->input('stripeToken');

        // 金額を取得
        $amount = $request->input('amount');

        // Stripeで支払いを作成
        try {
            $charge = Charge::create([
                'amount' => $amount * 100, // 金額をセント単位に変換
                'currency' => 'JPY',
                'source' => $token,
            ]);

            // 支払い成功後の処理を追加
            return redirect()->back()->with('success', '支払いが成功しました');
        } catch (\Exception $e) {
            // エラーハンドリング - エラーメッセージを表示など
            return redirect()->back()->with('error', '支払いに失敗しました: ' . $e->getMessage());
        }
    }

    public function createCharge(Request $request)
    {
        // オーナーが指定した金額を取得
        $amount = $request->input('amount');

        // 支払いを受ける処理を実行

        return redirect()->back()->with('success', '支払いを受け付けました');
    }
}
