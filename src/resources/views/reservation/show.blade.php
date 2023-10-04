<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>個人予約情報確認ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/show.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <!-- 共通ヘッダー -->
        <div class="common">
            <div class="header">
                <h1>Rese</h1>
            </div>
            <div class="header__right">
                <div class="header__content">
                    <div class="header__url">
                        <a href="{{ route('owner.index') }}">店舗情報管理</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner.reserve') }}">予約の確認</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner.qrcode') }}">QRコード検索</a>
                    </div>
                    <div class="header__logout">
                        <form class="logout__form" action="/logout" method="post">
                            @csrf
                            <button class="logout__button">ログアウト</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="show">
            <div class="container">
                <h1>QRコードから予約情報を取得しました。</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ユーザー名</th>
                            <th>店舗名</th>
                            <th>予約ID</th>
                            <th>予約日時</th>
                            <th>人数</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $reserve->user->name }}</td>
                            <td>{{ $reserve->shop->name }}</td>
                            <td>{{ $reserve->id }}</td>
                            <td>{{ $reserve->time }}</td>
                            <td>{{ $reserve->people }}人</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>