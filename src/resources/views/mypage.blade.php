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
                        <a href="{{ route('shops.index') }}">店舗一覧</a>
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
        <div class="mypage">
            <div class="mypage__head">
                <h1>{{ auth()->user()->name }}さんのマイページです。</h1>
            </div>
            <div class="mypage__content">
                <div class="mypage__reserve">
                    <div class="mypage__text">
                        <h1>ご予約状況</h1>
                    </div>
                    <div class="reserve__box">
                        @if($reserves && $reserves->count() > 0)
                            @foreach($reserves as $reserve)
                                <div class="reserve__info">
                                    <p>日付: {{ $reserve->day }}</p>
                                    <p>時間: {{ $reserve->time }}</p>
                                    <p>人数: {{ $reserve->people }}</p>
                                    <button class="reserve__edit-button">予約内容変更</button>
                                    <form action="{{ route('reservations.destroy', $reserve) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="reserve__delete-button">予約削除</button>
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <p>予約情報はありません。</p>
                        @endif
                    </div>
                </div>
                <div class="mypage__favorite">
                    <div class="mypage__text">
                        <h1>お気に入り店舗</h1>
                    </div>
                    <div class="favorite__box">
                        @if($favoriteShops->count() > 0)
                            @foreach($favoriteShops as $favoriteShop)
                                <div class="favorite__shop">
                                    <h2>{{ $favoriteShop->name }}</h2>
                                    <p>エリア: {{ $favoriteShop->area }}</p>
                                    <p>ジャンル: {{ $favoriteShop->genre }}</p>
                                    <form action="{{ route('favorites.remove', ['shop' => $favoriteShop]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">お気に入り解除</button>
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <p>お気に入り店舗はありません。</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>