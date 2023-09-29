<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Shop;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Shop $shop)
    {
        // レビューがすでに存在するか確認
        $existingReview = Review::where('user_id', auth()->id())
            ->where('shop_id', $shop->id)
            ->first();

        // $existingReview をビューに渡す
        return view('review', ['shop' => $shop, 'review' => $existingReview]);
    }

    public function store(Request $request, Shop $shop)
    {
        // レビューがすでに存在するか確認
        $existingReview = Review::where('user_id', auth()->id())
            ->where('shop_id', $shop->id)
            ->first();

        if ($existingReview) {
            // すでにレビューが存在する場合は更新
            return $this->updateReview($existingReview, $request);
        } else {
            // レビューが存在しない場合は新規作成
            return $this->createReview($request, $shop);
        }
    }

    private function createReview(Request $request, Shop $shop)
    {
        // レビューを保存するロジック
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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

        $review->save();

        return redirect()->route('mypage')->with('success', 'レビューを投稿しました。');
    }

    private function updateReview(Review $review, Request $request)
    {
        // レビューを更新するロジック
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');

        // 画像がアップロードされているかを確認
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('review_imgs');
            $review->img = $imgPath;
        }

        $review->save();

        return redirect()->route('mypage')->with('success', 'レビューを更新しました。');
    }
}
