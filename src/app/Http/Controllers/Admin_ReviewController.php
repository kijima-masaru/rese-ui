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
        $searchTerm = $request->input('user_name'); // 検索キーワードを取得

        // ユーザー名に一致する口コミを検索
        $reviews = Review::whereHas('user', function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        })->get();

        return view('admin_review', ['reviews' => $reviews]);
    }

    public function destroy(Review $review)
    {
        $review->delete(); // レビューを削除

        return redirect()->route('admin.reviews.index')->with('success', '口コミを削除しました。');
    }
}
