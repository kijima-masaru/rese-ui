<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\Shop;

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
}
