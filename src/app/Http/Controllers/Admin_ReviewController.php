<?php // 管理者口コミ閲覧・削除ページ用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class Admin_ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all(); // すべてのレビューを取得

        return view('admin_review', ['reviews' => $reviews]);
    }

    public function search(Request $request)
    {
        $userName = $request->input('user_name'); // ユーザー名の検索キーワードを取得
        $shopName = $request->input('shop_name'); // 店舗名の検索キーワードを取得

        // レビューを検索
        $reviews = Review::query();

        if (!empty($userName)) {
            $reviews->whereHas('user', function ($query) use ($userName) {
                $query->where('name', 'like', "%{$userName}%");
            });
        }

        if (!empty($shopName)) {
            $reviews->whereHas('shop', function ($query) use ($shopName) {
                $query->where('name', 'like', "%{$shopName}%");
            });
        }

        $reviews = $reviews->get();

        return view('admin_review', ['reviews' => $reviews]);
    }

    public function destroy(Review $review)
    {
        $review->delete(); // レビューを削除

        return redirect()->route('admin.reviews.index')->with('success', '口コミを削除しました。');
    }
}
