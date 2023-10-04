const scanner = new Instascan.Scanner({ video: document.getElementById('qrcode-scanner').querySelector('video') });

scanner.addListener('scan', function (content) {
    // QRコードを読み込んだ場合の処理
    document.getElementById('qrcode-result').textContent = '予約情報を読み込んでいます...';

    // QRコードから取得した予約IDを使って、リダイレクト先のURLを生成
    const redirectUrl = `/reservations/${content}`; // 相対パスを使用

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
