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
                            <button class="favorite-button" data-shop-id="{{ $shop->id }}" data-favorited="{{ $shop->isFavoritedBy(auth()->user()) ? 'true' : 'false' }}">
                                @if ($shop->isFavoritedBy(auth()->user()))
                                    お気に入り済み
                                @else
                                    お気に入りする
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    <!-- お気に入り登録・解除機能の記述 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.button__favorite').click(function() {
                var shopId = $(this).data('shop-id');
                var isFavorited = $(this).hasClass('favorited');

                $.ajax({
                    url: '/favorites/toggle',
                    type: 'POST',
                    data: { shop_id: shopId, favorited: isFavorited },
                    success: function(response) {
                        if (response.status === 'success') {
                            if (isFavorited) {
                                $(this).removeClass('favorited');
                            } else {
                                $(this).addClass('favorited');
                            }
                        }
                    }
                });
            });
        });
    </script>

    </main>
</body>