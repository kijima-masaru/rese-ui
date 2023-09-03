<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>個人予約情報閲覧ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/show.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <div class="show">
            <div class="container">
    <h1>予約詳細</h1>
    <table class="table">
        <thead>
            <tr>
                <th>予約ID</th>
                <th>予約日時</th>
                <th>人数</th>
                <th>ステータス</th>
                <th>ユーザー名</th>
                <th>店舗名</th>
                <!-- 他の予約情報を表示するヘッダーを追加 -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $reserve->id }}</td>
                <td>{{ $reserve->time }}</td>
                <td>{{ $reserve->people }}人</td>
                <td>{{ $reserve->status }}</td>
                <td>{{ $reserve->user->name }}</td> <!-- ユーザー名を表示 -->
                <td>{{ $reserve->shop->name }}</td> <!-- 店舗名を表示 -->
                <!-- 他の予約情報を表示するセルを追加 -->
            </tr>
        </tbody>
    </table>
</div>
        </div>
    </main>
</body>