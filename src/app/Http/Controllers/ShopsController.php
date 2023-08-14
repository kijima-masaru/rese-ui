<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
class ShopsController extends Controller
{
    public function index()
    {
        $shops = Shop::all(); // すべての店舗情報を取得

        return view('shops', ['shops' => $shops]); // ビューにデータを渡す
    }
}

