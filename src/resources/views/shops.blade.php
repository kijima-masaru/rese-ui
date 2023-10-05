<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>飲食店一覧ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/shops.css') }}" />
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
                    <div class="header__url">
                        <a href="{{ route('user_stripe.index') }}">決済ページ</a>
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
        <div class="shops">
            <!-- ページ本体 -->
            <div class="main">
                <div class="main__head">
                    <div class="shop__search">
                        <form action="{{ route('shops.search') }}" method="GET">
                            <input class="search__input" type="text" name="area" placeholder="エリアを入力">
                            <input class="search__input" type="text" name="genre" placeholder="ジャンルを入力">
                            <input class="search__input" type="text" name="name" placeholder="店名を入力">
                            <button type="submit">検索</button>
                        </form>
                    </div>
                    <div class="sort-buttons">
                        <label for="sort-select">店舗の順番を変える：</label>
                        <select id="sort-select" onchange="location = this.value;">
                            <option>選択する</option>
                            <option value="{{ route('shops.index') }}">デフォルト</option>
                            <option value="{{ route('shops.random') }}">ランダム</option>
                            <option value="{{ route('shops.high-rated') }}">評価が高い順</option>
                            <option value="{{ route('shops.low-rated') }}">評価が低い順</option>
                        </select>
                    </div>
                </div>
                @foreach ($shops as $shop)
                <div class="shop__card">
                    <div class="card__img">
                        <img src="{{ asset('storage/' . $shop->img) }}" alt="Shop Image">
                    </div>
                    <div class="card__content">
                        <div class="shop__name">
                            <h2>{{ $shop->name }}</h2>
                        </div>
                        <div class="view__content">
                            <p>★ {{ isset($avgRatingMap[$shop->id]) ? number_format($avgRatingMap[$shop->id], 1) : '評価なし' }}</p>
                        </div>
                        <div class="shop__view">
                            <div class="view__content">
                                <p>#{{ $areaDataMap[$shop->id]->area }}</p>
                            </div>
                            <div class="view__content">
                                <p>#{{ $genreDataMap[$shop->id]->genre }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card__button">
                        <div class="button__detail">
                            <a href="{{ route('shop.detail', ['shop' => $shop]) }}">詳しく見る</a>
                        </div>
                        <div class="button__favorite">
                            @if (auth()->check())
                                @if (auth()->user()->favoriteShops->contains($shop))
                                    <form action="{{ route('favorites.remove', ['shop' => $shop]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">お気に入り解除</button>
                                    </form>
                                @else
                                    <form action="{{ route('favorites.add', ['shop' => $shop]) }}" method="POST">
                                        @csrf
                                        <button type="submit">お気に入り追加</button>
                                    </form>
                            @endif
                            @else
                                <a href="{{ route('login') }}">ログインしてお気に入り追加</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>