<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // ユーザーモデルをインポート

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // すべてのユーザー情報を取得
        return view('admin', compact('users'));
    }

    // ユーザー一覧を取得し、ユーザー一覧ページに渡す
    public function userList()
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    // usersテーブルのroleを変更
    public function updateRole(Request $request, $userId)
    {
        $request->validate([
            'role' => ['required', 'in:admin,owner,user'],
        ]);

        $user = User::findOrFail($userId);
        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', '役割が更新されました。');
    }

    public function searchUsers(Request $request)
    {
        $searchTerm = $request->input('search');

        // ユーザー名で部分一致検索を実行
        $users = User::where('name', 'like', '%' . $searchTerm . '%')->get();

        return view('admin', compact('users'));
    }
}
