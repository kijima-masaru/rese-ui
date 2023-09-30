<?php //レビュー管理ページ表示用コントローラ

namespace App\Http\Controllers;

use App\Models\Review;

class Admin_ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all(); // すべてのレビューを取得

        return view('admin_review', ['reviews' => $reviews]);
    }

    public function destroy(Review $review)
    {
        $review->delete(); // レビューを削除

        return redirect()->route('admin.reviews.index')->with('success', 'レビューを削除しました。');
    }
}
