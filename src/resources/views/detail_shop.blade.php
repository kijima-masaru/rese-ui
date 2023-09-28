<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>飲食店詳細ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/detail_shop.css') }}" />
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
        <!-- ページ本体 -->
        <div class="detail">
            <div class="detail__shop">
                <div class="detail__img">
                    <img src="{{ asset('storage/' . $shop->img) }}" alt="Shop Image">
                </div>
                <div class="detail__name">
                    <h1>{{ $shop->name }}</h1>
                </div>
                <div class="detail__content">
                    <div class="detail__area">
                        <p>#{{ $shop->area->area }}</p> <!-- areasテーブルからの表示 -->
                    </div>
                    <div class="detail__genre">
                        <p>#{{ $shop->genre->genre }}</p> <!-- genresテーブルからの表示 -->
                    </div>
                </div>
                <div class="detail__overview">
                    <p>{{ $shop->overview }}</p>
                </div>
            </div>
            <div class="detail__reserve">
                <div class="reserve__head">
                    <h2>予約する</h2>
                </div>
                <form action="{{ route('reservations.store', ['shop' => $shop->id]) }}" method="post">
                    @csrf
                    <div class="reserve__form">
                        <label for="day">日付:</label>
                        <input type="date" name="day" required min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"><br>
                        @error('day')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="reserve__form">
                        <label for="time">時間:</label>
                        <input type="time" name="time" required><br>
                        @error('time')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="reserve__form">
                        <label for="people">人数:</label>
                        <input type="number" name="people" required min="1"><br>
                        @error('people')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="reserve__button">
                        <button type="submit">予約する</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>