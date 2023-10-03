<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;

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

    public function store(ReviewRequest $request, Shop $shop)
    {
        if ($existingReview = $this->getExistingReview($shop)) {
            // すでに口コミが存在する場合は更新
            return $this->updateReview($request, $existingReview);
        } else {
            // 口コミが存在しない場合は新規作成
            return $this->createReview($request, $shop);
        }
    }

    private function createReview(ReviewRequest $request, Shop $shop)
    {
        $review = new Review([
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'user_id' => auth()->id(),
            'shop_id' => $shop->id,
            'img' => null,
        ]);

        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('review_imgs');
            $review->img = $imgPath;
        }

        $review->save();

        return redirect()->back()->with('success', '口コミを投稿しました。');
    }

    private function updateReview(ReviewRequest $request, Review $review)
    {
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');

        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('review_imgs');
            $review->img = $imgPath;
        }

        $review->save();

        return redirect()->back()->with('success', '口コミを更新しました。');
    }

    public function destroy(Shop $shop, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            return redirect()->back()->with('error', '権限がありません。');
        }

        $review->delete();

        return redirect()->back()->with('success', '口コミを削除しました。');
    }

    private function getExistingReview(Shop $shop)
    {
        return Review::where('user_id', auth()->id())
            ->where('shop_id', $shop->id)
            ->first();
    }
}
