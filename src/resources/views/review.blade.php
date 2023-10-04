<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>口コミ投稿ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
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
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
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
        <!-- レビュー内容投稿フォーム -->
        <div class="review">
            <div class="review__head">
                <h1>
                    @if(isset($review))
                        店舗の口コミを更新できます。
                    @else
                        店舗の口コミを投稿できます。
                    @endif
                </h1>
            </div>
            <div class="review__form">
                <form method="POST" action="{{ route('review.store', ['shop' => $shop->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form__group">
                        <label for="rating">1~5段階評価:</label>
                        <div class="star-rating">
                            <input type="hidden" name="rating" id="rating" value="{{ old('rating', isset($review) ? $review->rating : '0') }}">
                            <span class="star{{ old('rating', isset($review) ? $review->rating : '0') >= 1 ? ' active' : '' }}" data-rating="1">☆</span>
                            <span class="star{{ old('rating', isset($review) ? $review->rating : '0') >= 2 ? ' active' : '' }}" data-rating="2">☆</span>
                            <span class="star{{ old('rating', isset($review) ? $review->rating : '0') >= 3 ? ' active' : '' }}" data-rating="3">☆</span>
                            <span class="star{{ old('rating', isset($review) ? $review->rating : '0') >= 4 ? ' active' : '' }}" data-rating="4">☆</span>
                            <span class="star{{ old('rating', isset($review) ? $review->rating : '0') >= 5 ? ' active' : '' }}" data-rating="5">☆</span>
                            @error('rating')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form__group">
                        <label for="comment">口コミ(400字以内):</label>
                        <textarea name="comment" rows="4" cols="50" maxlength="400">{{ old('comment', isset($review) ? $review->comment : '') }}</textarea>
                        @error('comment')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="form__group">
                        <label for="img">画像をアップロード:</label>
                        <input type="file" name="img" accept="image/*">
                        @error('img')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    <div class="form__button">
                        @if(isset($review))
                            <button type="submit">口コミを更新</button>
                        @else
                            <button type="submit">口コミを投稿</button>
                        @endif
                    </div>
                </form>
                <!-- レビュー削除フォーム -->
                <div class="delete__button">
                    @if(isset($review))
                        <form method="POST" action="{{ route('review.destroy', ['shop' => $shop->id, 'review' => $review->id]) }}">
                            @csrf
                            @method('DELETE')
                            <div class="form__button">
                                <button type="submit">口コミを削除</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/review.js') }}"></script>
</body>
</html>
