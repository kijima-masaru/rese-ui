<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Favorite;

class FavoritesController extends Controller
{
    public function add(Shop $shop)
    {
        auth()->user()->favorites()->attach($shop->id);
        return redirect()->back()->with('success', 'お気に入りに追加しました');
    }

    public function remove(Shop $shop)
    {
        auth()->user()->favorites()->detach($shop->id);
        return redirect()->back()->with('success', 'お気に入りを解除しました');
    }
}
