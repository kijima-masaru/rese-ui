<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>パスワード再設定ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <!-- 共通ヘッダー -->
        <div class="common">
            <div class="header__Atte">
                <h1>Atte</h1>
            </div>
        </div>

        <!-- ページ全体 -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h1>パスワードの再設定を行います。</h1>
                        </div>

                        <div class="card-body">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">
                                        <p>ご登録したメールアドレスを入力してください。パスワード再設定メールを送信します。</p>
                                    </label>

                                    <div class="col-md-6">
                                        <div class="form__input">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス"/>
                                        </div>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button class="button__submit" type="submit" class="btn btn-primary">
                                            {{ __('メールを送信する') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--ログインページへのアクセス-->
                <div class="register__form-content">
                    <div class="content__text">
                        <p>ログインはこちらから</p>
                    </div>
                    <div class="content__register">
                        <a href="{{ route('login') }}">ログイン</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>