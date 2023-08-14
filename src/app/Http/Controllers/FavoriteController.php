<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $shopId = $request->input('shop_id');
        $userId = auth()->user()->id;

        $favorite = Favorite::where('user_id', $userId)
            ->where('shop_id', $shopId)
            ->first();

        if ($favorite) {
            $favorite->delete(); // Already favorited, so remove from favorites
            return response()->json(['status' => 'success', 'action' => 'removed']);
        } else {
            Favorite::create([
                'user_id' => $userId,
                'shop_id' => $shopId
            ]);
            return response()->json(['status' => 'success', 'action' => 'added']);
        }
    }
}
