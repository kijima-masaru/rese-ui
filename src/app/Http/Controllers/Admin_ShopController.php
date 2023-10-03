<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CSVImportRequest;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Admin_ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::where('user_id', Auth::id())->get();

        return view('admin_shop', compact('shops'));
    }

    public function import(CSVImportRequest $request)
    {
        // アップロードされたCSVファイルを取得
        $csvFile = $request->file('csv_file');

        // CSVファイルの一時的な保存先パスを生成
        $csvPath = $csvFile->storeAs('csv', uniqid('import_', true) . '.' . $csvFile->getClientOriginalExtension());

        // CSVファイルの各行を処理
        $csvData = file_get_contents(storage_path('app/public/' . $csvPath));
        $lines = explode(PHP_EOL, $csvData);

        $errors = [];

        foreach ($lines as $lineNumber => $line) {
            $data = str_getcsv($line);

            // データのバリデーション
            $validator = Validator::make($data, [
                '0' => 'required|max:50',
                '1' => ['required', Rule::in(['東京都', '大阪府', '福岡県'])],
                '2' => ['required', Rule::in(['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'])],
                '3' => 'required|max:400',
                '4' => ['required', 'url', 'regex:/\.(jpeg|png)$/i'], // 画像URL：jpeg, png のみ対応
            ]);

            if ($validator->fails()) {
                $errorMessages = [
                    '0' => '店舗名は50文字以内で必須です。',
                    '1' => 'エリアは「東京都」「大阪府」「福岡県」のいずれかで必須です。',
                    '2' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかで必須です。',
                    '3' => '店舗の概要は400文字以内で必須です。',
                    '4' => '画像URLはjpeg、jpg、pngの形式で必須です。',
                ];

                foreach ($validator->errors()->keys() as $key) {
                    $errors[] = $errorMessages[$key];
                }

                continue;
            }

            // データを処理するロジック
            $name = $data[0];
            $area = $data[1];
            $genre = $data[2];
            $overview = $data[3];
            $imgPath = $data[4];

            // 画像ファイルをダウンロードして保存
            $imgContents = file_get_contents($imgPath);
            $imgExtension = pathinfo($imgPath, PATHINFO_EXTENSION);
            $imgFileName = uniqid('', true) . '.' . $imgExtension;

            // 画像を public/img ディレクトリに保存
            Storage::disk('public')->put('img/' . $imgFileName, $imgContents);

            // 店舗情報をデータベースに追加
            $shop = new Shop();
            $shop->name = $name;
            $shop->overview = $overview;
            $shop->img = 'img/' . $imgFileName;
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

        if (!empty($errors)) {
            return redirect()->route('admin.shop.index')->withErrors(['csv_file' => implode('<br>', $errors)])->withInput();
        }

        return redirect()->route('admin.shop.index')->with('success', '店舗情報を作成しました');
    }
}

