<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QRコード読み取りページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/owner_qrcode.css') }}" />
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
        <!-- ページ本体 -->
        <div class="owner__qrcode">
            <div class="qrcode__head">
                <h1>QRコードをスキャンしてください。</h1>
                <p>スキャン開始ボタンを押してカメラを起動しましょう。</p>
            </div>
            <!-- QRコードを表示するリンク -->
            <div class="reserve__qrcode">
                <!-- QRコードをスキャンするためのカメラ画面 -->
                <div id="qrcode-scanner">
                    <video autoplay></video>
                    <button id="start-scan">スキャン開始</button>
                </div>
                <!-- QRコードを読み込んだ情報を表示する領域 -->
                <div id="qrcode-result"></div>
            </div>
        </div>
    </main>
    <script src="https://cdn.rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="{{ asset('js/owner_qrcode.js') }}"></script>
</body>
</html>