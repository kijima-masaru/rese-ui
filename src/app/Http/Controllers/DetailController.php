<?php //店舗詳細表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class DetailController extends Controller
{
    public function index(Shop $shop)
    {
        return view('detail_shop', compact('shop'));
    }
}