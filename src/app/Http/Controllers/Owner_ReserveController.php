<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\Shop;
// お知らせメール送信のためのインポート
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationNotification;

class Owner_ReserveController extends Controller
{
    public function index()
    {
        // ログインユーザーのIDを取得
        $userId = auth()->user()->id;

        // ログインユーザーが所有する店舗情報を取得
        $shops = Shop::where('user_id', $userId)->get();

        // 店舗ごとの予約情報を取得
        $reservations = [];
        foreach ($shops as $shop) {
            $reservations[$shop->id] = Reserve::where('shop_id', $shop->id)
                ->with('user')
                ->get();
        }

        return view('owner_reserve', compact('shops', 'reservations'));
    }

    // お客様ご来店後に予約状況を変更する機能
    public function updateStatus($id)
    {
        $reservation = Reserve::findOrFail($id);

        $reservation->status = 'after'; $reservation->save();

        // 変更が完了したらリダイレクト
        return redirect()->route('owner.reserve');
    }
    public function sendNotificationEmail($id)
    {
        try {
            // 予約情報を取得
            $reservation = Reserve::findOrFail($id);

            // 予約したユーザーを取得
            $user = $reservation->user;

            // メールを送信
            Mail::to($user->email)->send(new ReservationNotification($reservation));

            return redirect()->route('owner.reserve')->with('success', 'お知らせメールを送信しました。');
        } catch (\Exception $e) {
            return redirect()->route('owner.reserve')->with('error', 'お知らせメールの送信に失敗しました。');
        }
    }

}