<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>認証メール確認ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <!--共通ヘッダー-->
        <div class="common">
            <div class="header__Atte">
                <h1>Atte</h1>
            </div>
        </div>

        <div class="mail">
            <!--認証メール案内-->
            <div class="mail__head">
                <div class="mail__text">
                    <h1>ご登録したメールアドレスに認証メールを送信しました。</h1>
                </div>
                <div class="mail__text">
                    <h2>認証メールを確認し、会員登録を完了してください。</h2>
                </div>
                <div class="mail__red">
                    <p>※メールにて会員登録を完了させないとログインできません。</p>
                </div>
            </div>

            <!--認証メール再送信-->
            <div class="mail__button">
                <div class="form__button">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="button__submit" type="submit">認証メールの再送信はこちら</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
