<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>予約内容変更ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/reservation_edit.css') }}" />
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
        <div class="edit">
            <div class="edit__head">
                <h1>予約内容を変更する</h1>
            </div>
            @foreach ($reservations as $reservation)
            <div class="edit__form">
                <form action="{{ route('update_reservation') }}" method="post">
                    @csrf
                    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                    <div class="form__img">
                        <img src="{{ asset('storage/' . $reservation->shop->img . '.jpeg') }}" alt="店舗画像">
                    </div>
                    <div class="form__name">
                        <h2>{{ $reservation->shop->name }}</h2>
                    </div>
                    <div class="form__group">
                        <label for="day">日付:</label>
                        <input type="date" id="day" name="day" value="{{ $reservation->day }}">
                    </div>
                    <div class="form__group">
                        <label for="time">時間:</label>
                        <input type="time" id="time" name="time" value="{{ $reservation->time }}">
                    </div>
                    <div class="form__group">
                        <label for="people">人数:</label>
                        <input type="number" id="people" name="people" value="{{ $reservation->people }}">
                    </div>
                    <div class="form__button">
                        <button type="submit">予約の内容を変更</button>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </main>
</body>
</html>
