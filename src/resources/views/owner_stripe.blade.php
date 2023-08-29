<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>オーナー決済ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/user_stripe.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <script src="https://js.stripe.com/v3/"></script>
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
                        <a href="{{ route('owner.index') }}">店舗情報の作成・更新</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner.reserve') }}">予約情報の確認</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner_stripe.index') }}">決済ページ</a>
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
        <div class="owner__stripe">
            <div class="stripe__form">
                <form action="{{ route('charge') }}" method="POST">
                    @csrf
                    <div class="form__content">
                        <label for="amount">金額:</label>
                        <input type="text" name="amount" id="amount">
                    </div>
                    <div class="form__button">
                        <!-- Stripe.jsの統合 -->
                        <script>
                            var stripe = Stripe('{{ config('services.stripe.key') }}');
                            var elements = stripe.elements();

                            // カード情報入力フォームのスタイルを設定
                            var style = {
                                base: {
                                    fontSize: '16px',
                                    color: '#32325d',
                                },
                            };

                            // カード情報入力フォームを生成
                            var card = elements.create('card', {
                                style: style,
                            });

                            // カード情報入力フォームをマウント
                            card.mount('#card-element');

                            // カード情報入力時のエラーハンドリング
                            card.on('change', function(event) {
                                var displayError = document.getElementById('card-errors');
                                if (event.error) {
                                    displayError.textContent = event.error.message;
                                } else {
                                    displayError.textContent = '';
                                }
                            });

                            // フォームのサブミット時にStripeトークンを生成
                            var form = document.getElementById('payment-form');
                            form.addEventListener('submit', function(event) {
                                event.preventDefault();

                                stripe.createToken(card).then(function(result) {
                                    if (result.error) {
                                        // エラーがあればエラーメッセージを表示
                                        var errorElement = document.getElementById('card-errors');
                                        errorElement.textContent = result.error.message;
                                    } else {
                                        // トークンが生成されたらフォームに追加して送信
                                        var tokenInput = document.createElement('input');
                                        tokenInput.setAttribute('type', 'hidden');
                                        tokenInput.setAttribute('name', 'stripeToken');
                                        tokenInput.setAttribute('value', result.token.id);
                                        form.appendChild(tokenInput);
                                        form.submit();
                                    }
                                });
                            });
                        </script>
                        <!-- カード情報入力フォーム -->
                        <div id="card-element"></div>
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <div class="form__button">
                        <button type="submit">支払いを受ける</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

