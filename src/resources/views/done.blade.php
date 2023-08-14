<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>予約完了ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/done.css.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <div class="done">
            <!-- 共通ヘッダー -->
            <div class="common">
                <div class="header">
                    <h1>Rese</h1>
                </div>
                <div class="header__right">
                    <div class="header__content">
                        <div class="header__url">
                            <a href="{{ route('mypage') }}">マイページ</a>
                        </div>
                        <div class="header__url">
                            <a href="{{ route('shops') }}">店舗一覧</a>
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
            <div class="main">
                <div class="text">ご予約ありがとうございます。</div>
                <div class="button">
                    <button class="button__submit" type="submit">マイページへ</button>
                </div>
            </div>
        </div>
    </main>
</body>