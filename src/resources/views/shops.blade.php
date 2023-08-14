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
                        <a>マイページ</a>
                    </div>
                    <div class="header__url">
                        <a>店舗一覧</a>
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
                <div class="shop__search">
                    <form action="{{ route('shops.search') }}" method="GET">
                        <input type="text" name="area" placeholder="エリアを入力">
                        <input type="text" name="genre" placeholder="ジャンルを入力">
                        <input type="text" name="name" placeholder="店名を入力">
                        <button type="submit">検索</button>
                    </form>
                </div>
                @foreach ($shops as $shop)
                <div class="shop__card">
                    <div class="card__img">
                        @if ($shop->img === 'ramen')
                            <img src="{{ asset('storage/ramen.jpeg') }}" alt="Ramen Shop Image">
                        @elseif ($shop->img === 'sushi')
                            <img src="{{ asset('storage/sushi.jpeg') }}" alt="Sushi Shop Image">
                        @elseif ($shop->img === 'italian')
                            <img src="{{ asset('storage/italian.jpeg') }}" alt="Italian Shop Image">
                        @elseif ($shop->img === 'izakaya')
                            <img src="{{ asset('storage/izakaya.jpeg') }}" alt="Izakaya Shop Image">
                        @elseif ($shop->img === 'yakiniku')
                            <img src="{{ asset('storage/yakiniku.jpeg') }}" alt="Yakiniku Shop Image">
                        @else
                            <img src="{{ asset('storage/default.jpeg') }}" alt="Default Shop Image">
                        @endif
                    </div>
                    <div class="card__content">
                        <div class="shop__name">
                            <h2>{{ $shop->name }}</h2>
                        </div>
                        <div class="shop__view">
                            <div class="view__area">
                                <p>#{{ $shop->area }}</p>
                            </div>
                            <div class="view__genre">
                                <p>#{{ $shop->genre }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card__button">
                        <div class="button__detail"></div>
                        <div class="button__favorite">
                            @if (auth()->check() && $shop->isFavoritedBy(auth()->user()))
                                <form action="{{ route('favorites.remove', ['shop' => $shop]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit">お気に入り解除</button>
                                </form>
                            @elseif (auth()->check())
                                <form action="{{ route('favorites.add', ['shop' => $shop]) }}" method="POST">
                                    @csrf
                                        <button type="submit">お気に入り追加</button>
                                </form>
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