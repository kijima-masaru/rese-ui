<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート
use App\Models\Shop; // Shopモデルをインポート
use App\Models\Area; // Areaモデルをインポート
use App\Models\Genre; // Genreモデルをインポート
// 以下はCSVのインポートで使用
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class Admin_ShopController extends Controller
{
    public function index()
    {
        // ログインユーザーが作成した店舗情報を取得
        $shops = Shop::where('user_id', Auth::id())->get();

        return view('admin_shop', compact('shops'));
    }

    public function store(Request $request)
    {
        // 画像をアップロード
        // ローカルストレージ用
        $imgPath = $request->file('img')->store('img');

        // 新しい店舗情報を作成して保存
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->overview = $request->input('overview');

        // 画像のパスをデータベースに保存
        $shop->img = $imgPath;

        $shop->user_id = $request->input('user_id');
        $shop->save();

        // areasテーブルに保存
        $area = new Area();
        $area->area = $request->input('area');
        $area->shop_id = $shop->id;
        $area->save();

        // genresテーブルに保存
        $genre = new Genre();
        $genre->genre = $request->input('genre');
        $genre->shop_id = $shop->id;
        $genre->save();

        // リダイレクトまたは適切な応答を返す
        return redirect()->route('admin.shop.index')->with('success', '店舗情報を作成しました！');
    }

    public function import(Request $request)
    {
        // バリデーションルールを設定
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        // バリデーションエラーがある場合はエラーメッセージを表示
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // アップロードされたCSVファイルを取得
        $csvFile = $request->file('csv_file');

        // CSVファイルの一時的な保存先パスを生成
        $csvPath = $csvFile->storeAs('public/csv', uniqid('import_', true) . '.' . $csvFile->getClientOriginalExtension());

        // CSVファイルの各行を処理
        $csvData = file_get_contents(storage_path('app/public/' . $csvPath));
        $lines = explode(PHP_EOL, $csvData);

        foreach ($lines as $line) {
            $data = str_getcsv($line);

            // データのバリデーション
            if (count($data) !== 5) {
                continue; // データの形式が正しくない場合はスキップ
            }

            $name = $data[0];
            $area = $data[1];
            $genre = $data[2];
            $overview = $data[3];
            $imgPath = $data[4];

            // 画像ファイルをダウンロードして保存
            $imgFile = file_get_contents($imgPath);
            $imgExtension = pathinfo($imgPath, PATHINFO_EXTENSION);
            $imgFileName = uniqid('img_', true) . '.' . $imgExtension;
            Storage::disk('public')->put('img/' . $imgFileName, $imgFile);

            // 店舗情報をデータベースに追加
            $shop = new Shop();
            $shop->name = $name;
            $shop->overview = $overview;
            $shop->img = $imgFileName;
            $shop->user_id = Auth::id();
            $shop->save();

            // エリアをデータベースに追加
            $areaModel = new Area();
            $areaModel->area = $area;
            $areaModel->shop_id = $shop->id;
            $areaModel->save();

            // ジャンルをデータベースに追加
            $genreModel = new Genre();
            $genreModel->genre = $genre;
            $genreModel->shop_id = $shop->id;
            $genreModel->save();
        }

        // 一時的に保存したCSVファイルを削除
        Storage::delete($csvPath);

        return redirect()->route('admin.shop.index')->with('success', 'CSVをインポートしました！');
    }
}
