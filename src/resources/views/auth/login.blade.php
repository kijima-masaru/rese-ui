<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ログインページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
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
        <div class="login">
            <div class="login__head">
                <h1>ログイン</h1>
            </div>
            <!--会員登録完了メッセージ-->
            <div class="login__success">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
            </div>
            <div class="login__form">
                <!--ログインフォーム-->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="login__form-main">
                        <div class="form__input">
                            <input type="email" name="email" placeholder="メールアドレス"/>
                        </div>
                        <div class="form__input">
                            <input type="password" name="password" placeholder="パスワード"/>
                        </div>
                        <div class="form__button">
                            <button class="button__submit" type="submit">ログイン</button>
                        </div>
                    </div>
                </form>
                <!--会員登録ページへのアクセス-->
                <div class="login__form-content">
                    <div class="content__text">
                        <p>アカウントをお持ちでない方はこちらから</p>
                    </div>
                    <div class="content__link">
                        <a href="{{ route('register') }}">会員登録</a>
                    </div>
                </div>
                <!--パスワード再設定ページへのアクセス-->
                <div class="login__form-content">
                    <div class="content__text">
                        <p>パスワードをお忘れの方はこちら</p>
                    </div>
                    <div class="content__link">
                        <a href="{{ route('password.request') }}">パスワードの再設定</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>