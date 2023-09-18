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
                        <a href="{{ route('owner.index') }}">店舗情報の作成・更新</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner.reserve') }}">予約情報の確認</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner.qrcode') }}">QRコードで予約検索</a>
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
    <script>
        const scanner = new Instascan.Scanner({ video: document.getElementById('qrcode-scanner').querySelector('video') });

        scanner.addListener('scan', function (content) {
            // QRコードを読み込んだ場合の処理
            document.getElementById('qrcode-result').textContent = '予約情報を読み込んでいます...';

            // QRコードから取得した予約IDを使って、リダイレクト先のURLを生成
            const redirectUrl = "{{ url('/reservations/') }}/" + content;

            // リダイレクト先のURLに遷移
            window.location.href = redirectUrl;
        });

        document.getElementById('start-scan').addEventListener('click', function () {
            // スキャン開始ボタンがクリックされた場合、カメラを起動してQRコードをスキャン
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]); // デフォルトのカメラを使用
                } else {
                    alert('カメラが見つかりません。');
                }
            }).catch(function (error) {
                console.error(error);
            });
        });
    </script>
</body>
</html>