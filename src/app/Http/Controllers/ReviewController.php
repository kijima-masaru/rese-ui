<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Shop;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Shop $shop)
    {
        // 口コミがすでに存在するか確認
        $existingReview = Review::where('user_id', auth()->id())
            ->where('shop_id', $shop->id)
            ->first();

        // $existingReview をビューに渡す
        return view('review', ['shop' => $shop, 'review' => $existingReview]);
    }

    public function store(Request $request, Shop $shop)
    {
        // 口コミがすでに存在するか確認
        $existingReview = Review::where('user_id', auth()->id())
            ->where('shop_id', $shop->id)
            ->first();

        if ($existingReview) {
            // すでに口コミが存在する場合は更新
            return $this->updateReview($existingReview, $request);
        } else {
            // 口コミが存在しない場合は新規作成
            return $this->createReview($request, $shop);
        }
    }

    private function createReview(Request $request, Shop $shop)
    {
        // 口コミを保存するロジック
        $request->validate([
            'rating' => 'required|integer|between:1,5', // 1から5の評価
            'comment' => 'nullable|string|max:400', // 最大400文字の自由記述
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像アップロード
        ]);

        $review = new Review([
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'user_id' => auth()->id(),
            'shop_id' => $shop->id,
            'img' => null, // 画像がアップロードされていない場合、nullをセット
        ]);

        // 画像がアップロードされているかを確認
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('review_imgs');
            $review->img = $imgPath;
        }

        $review->save();

        return redirect()->back()->with('success', '口コミを投稿しました。');
    }

    private function updateReview(Review $review, Request $request)
    {
        // レビューを更新するロジック
        $request->validate([
            'rating' => 'required|integer|between:1,5', // 1から5の評価
            'comment' => 'nullable|string|max:400', // 最大400文字の自由記述
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像アップロード
        ]);

        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');

        // 画像がアップロードされているかを確認
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('review_imgs');
            $review->img = $imgPath;
        }

        $review->save();

        return redirect()->back()->with('success', '口コミを更新しました。');
    }

    public function destroy(Shop $shop, Review $review)
    {
        // レビューの所有権を確認
        if ($review->user_id !== auth()->id()) {
            return redirect()->back()->with('error', '権限がありません。');
        }

        // レビューを削除
        $review->delete();

        return redirect()->back()->with('success', '口コミを削除しました。');
    }
}

