<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\Review;

class ReviewController extends Controller
{
    public function create(Reserve $reserve)
    {
        // レビューフォームを表示するためのビューを返す
        return view('review', compact('reserve'));
    }

    public function store(Request $request, Reserve $reserve)
    {
        // レビューを保存する前に予約のステータスを確認
        if ($reserve->status !== 'after') {
            return redirect()->route('home')->with('error', '予約が終了していないため、レビューを投稿できません。');
        }

        // レビューを保存するロジック
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = new Review([
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        $review->user_id = $reserve->user_id;
        $review->shop_id = $reserve->shop_id;
        $review->reserve_id = $reserve->id;
        $review->save();

        // 関連するReserveのstatusを更新
        $reserve->update(['status' => 'reviewed']);

        return redirect()->route('mypage')->with('success', 'レビューが正常に保存されました。');
    }
}
