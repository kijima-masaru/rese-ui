<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class OwnerController extends Controller
{
    public function index()
    {
        $shops = Shop::where('user_id', Auth::id())->get();

        return view('owner', compact('shops'));
    }

    public function store(Request $request)
    {
        $imgPath = $request->file('img')->store('img');

        $shop = new Shop();
        $shop->name = $request->input('name');
        $area = Area::firstOrCreate(['area' => $request->input('area')]);
        $genre = Genre::firstOrCreate(['genre' => $request->input('genre')]);
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->overview = $request->input('overview');
        $shop->img = $imgPath;
        $shop->user_id = $request->input('user_id');
        $shop->save();

        return redirect()->route('owner.index')->with('success', '店舗情報を作成しました！');
    }

    public function edit()
    {
        $shops = Shop::where('user_id', Auth::id())->get();

        return view('owner', compact('shops'));
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);

        if ($shop->user_id !== Auth::id()) {
            return abort(403, 'You are not authorized to edit this shop.');
        }

        $shop->name = $request->input('name');
        $area = Area::firstOrCreate(['area' => $request->input('area')]);
        $genre = Genre::firstOrCreate(['genre' => $request->input('genre')]);
        $shop->area_id = $area->id;
        $shop->genre_id = $genre->id;
        $shop->overview = $request->input('overview');
        $shop->save();

        return redirect()->route('owner.edit')->with('success', '店舗情報を更新しました！');
    }

    public function editImage($id)
    {
        $shop = Shop::findOrFail($id);

        if ($shop->user_id !== Auth::id()) {
            return abort(403, 'You are not authorized to edit this shop.');
        }

        return view('owner.edit-image', compact('shop'));
    }

    public function updateImage(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);

        if ($shop->user_id !== Auth::id()) {
            return abort(403, 'You are not authorized to edit this shop.');
        }

        $newImgPath = $request->file('img')->store('img');

        if ($shop->img) {
            Storage::delete($shop->img);
        }

        $shop->img = $newImgPath;
        $shop->save();

        return redirect()->route('owner.edit', $id)->with('success', '店舗情報の画像を更新しました！');
    }
}
