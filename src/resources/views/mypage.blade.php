<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>マイページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <div class="mypage">
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
                <div class="main_head">
                    <h1>{{ auth()->user()->name }}さんのマイページです。</h1>
                </div>
                <div class="main_reserve">
                    <div class="text">
                        <h1>ご予約状況</h1>
                    </div>
                    <div class="reserve_box"></div>
                </div>
                <div class="main_favorite">
                    <div class="text">
                        <h1>お気に入り店舗</h1>
                    </div>
                    <div class="favorite_box"></div>
                </div>
            </div>
        </div>
    </main>
</body>