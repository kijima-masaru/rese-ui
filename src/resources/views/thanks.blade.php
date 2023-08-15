<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>サンクスページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <!--共通ヘッダー-->
        <div class="common">
            <div class="header">
                <h1>Rese</h1>
            </div>
        </div>

        <!--ページ本体-->
        <div class="thanks">
            <div class="thanks__message">
                <h1>ご登録ありがとうございます。</h1>
            </div>
            <!--ログインページへのアクセス-->
                <div class="register__form-content">
                    <div class="content__text">
                        <p>ログインはこちらから</p>
                    </div>
                    <div class="content__register">
                        <a href="{{ route('login') }}">ログイン</a>
                    </div>
                </div>
        </div>
    </main>
</body>