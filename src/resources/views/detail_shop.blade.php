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
            <!-- フォームエラーメッセージ -->
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <div class="alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                </ul>
            @endif
            <div class="detail__shop">
                <div class="detail__img">
                    <img src="{{ asset('storage/' . $shop->img) }}" alt="Shop Image">
                </div>
                <div class="detail__name">
                    <h1>{{ $shop->name }}</h1>
                    <p>★ {{ $averageRating !== null ? number_format($averageRating, 1) : '評価なし' }}</p>
                </div>
                <div class="detail__content">
                    <div class="detail__area">
                        <p>#{{ $area }}</p>
                    </div>
                    <div class="detail__genre">
                        <p>#{{ $genre }}</p>
                    </div>
                </div>
                <div class="detail__overview">
                    <p>{{ $shop->overview }}</p>
                </div>
                <div class="detail__review">
                    <a href="{{ route('review.create', ['shop' => $shop->id]) }}">【口コミを書く・更新する】</a>
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
        <!-- 口コミ表示 -->
        <div class="detail__reviews">
            <h2>店舗の口コミ</h2>
            <!-- 口コミソート用のセレクトボックス -->
            <div class="detail__sort">
                <form action="{{ route('shop.detail', ['shop' => $shop]) }}" method="get">
                    <label for="sort">口コミの並びかえ：</label>
                    <select name="sort" id="sort" onchange="this.form.submit()">
                        <option value="default" {{ $sort == 'default' ? 'selected' : '' }}>デフォルト</option>
                        <option value="random" {{ $sort == 'random' ? 'selected' : '' }}>ランダム</option>
                        <option value="high-rated" {{ $sort == 'high-rated' ? 'selected' : '' }}>評価が高い順</option>
                        <option value="low-rated" {{ $sort == 'low-rated' ? 'selected' : '' }}>評価が低い順</option>
                    </select>
                </form>
            </div>
            @if($reviews->count() > 0)
                <ul>
                    @foreach($reviews as $review)
                        <li>
                            <p>評価: ★{{ $review->rating }}</p>
                            <p>コメント: {{ $review->comment }}</p>
                            @if($review->img)
                                <img src="{{ asset('storage/' . $review->img) }}" alt="Review Image">
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p>まだ口コミがありません。</p>
            @endif
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 日付と時間の入力要素を取得
            var dateInput = document.querySelector('input[name="day"]');
            var timeInput = document.querySelector('input[name="time"]');

            // 現在の日付と時間を取得
            var now = new Date();
            var currentYear = now.getFullYear();
            var currentMonth = (now.getMonth() + 1).toString().padStart(2, '0');
            var currentDay = now.getDate().toString().padStart(2, '0');
            var currentHour = now.getHours().toString().padStart(2, '0');
            var currentMinute = now.getMinutes().toString().padStart(2, '0');

            // 最小日付を今日の日付に設定
            dateInput.min = currentYear + '-' + currentMonth + '-' + currentDay;

            // 日付が今日の場合、時間の最小値を現在の時間に設定
            dateInput.addEventListener('change', function () {
                if (dateInput.value === (currentYear + '-' + currentMonth + '-' + currentDay)) {
                timeInput.min = currentHour + ':' + currentMinute;
                } else {
                    // 日付が変更された場合、時間の最小値をクリア
                    timeInput.min = '';
                }
            });
        });
    </script>
</body>
</html>