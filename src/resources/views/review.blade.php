<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>レビューページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/review.css') }}" />
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
        <div class="review">
            <div class="review__head">
                <h1>ご利用した店舗のレビューができます。</h1>
            </div>
                @if ($reserve && $reserve->status === 'after')
                <div class="review__form">
                    <form method="POST" action="{{ route('review.store', $reserve) }}">
                        @csrf
                        <div class="form__group">
                            <label for="rating">1~5段階評価:</label>
                            <input type="number" name="rating" min="1" max="5" required>
                        </div>
                        <div class="form__group">
                            <label for="comment">コメント:</label>
                            <textarea name="comment" rows="4" cols="50"></textarea>
                        </div>
                        <div class="form__button">
                            <button type="submit">レビューを投稿</button>
                        </div>
                    </form>
                </div>
                @endif
        </div>
    </main>
</body>