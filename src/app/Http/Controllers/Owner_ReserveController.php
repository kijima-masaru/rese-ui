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
            $reservations[$shop->id] = Reserve::where('shop_id', $shop->id)->get();
        }

        return view('owner_reserve', compact('shops', 'reservations'));
    }
}
