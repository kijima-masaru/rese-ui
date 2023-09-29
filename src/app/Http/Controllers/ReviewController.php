<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Shop;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Shop $shop)
{
    // レビューフォームを表示するためのビューを返す
    return view('review', ['shop' => $shop]);
}

public function store(Request $request, Shop $shop)
{
    // レビューを保存するロジック
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    //dd($shop); // デバッグ情報を表示

    $review = new Review([
        'rating' => $request->input('rating'),
        'comment' => $request->input('comment'),
        'user_id' => auth()->id(), // ログインユーザーのIDを設定
        'shop_id' => $shop->id, // 店舗のIDを設定
        'status' => 'reviewed',
    ]);

    // 画像がアップロードされているかを確認
    if ($request->hasFile('img')) {
        $imgPath = $request->file('img')->store('review_imgs');
        $review->img = $imgPath;
    }

    // レビューを保存する他の必要なロジックを実装

    $review->save();

    return redirect()->route('mypage')->with('success', 'レビューを投稿しました。');
    }
}
