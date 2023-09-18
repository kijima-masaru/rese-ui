<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>会員登録ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <!--共通ヘッダー-->
        <div class="common">
            <div class="header">
                <h1>Rese</h1>
            </div>
        </div>
        <div class="register">
            <div class="register__head">
                <h1>会員登録</h1>
            </div>
            <div class="register__form">
                <!--新規登録フォーム-->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="register__form-main">
                        <div class="form__input">
                            <input type="text" name="name" placeholder="名前" value="{{ old('name') }}" />
                            @error('name')
                            <p class="form__error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__input">
                            <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" />
                            @error('email')
                            <p class="form__error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__input">
                            <input type="password" name="password" placeholder="パスワード" />
                            @error('password')
                            <p class="form__error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__input">
                            <input type="password" name="password_confirmation" placeholder="確認用パスワード" />
                        </div>
                        <div class="form__button">
                            <button class="button__submit" type="submit">会員登録</button>
                        </div>
                    </div>
                </form>
                <!--ログインページへのアクセス-->
                <div class="register__form-content">
                    <div class="content__text">
                        <p>アカウントをお持ちの方はこちらから</p>
                    </div>
                    <div class="content__link">
                        <a href="{{ route('login') }}">ログイン</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>