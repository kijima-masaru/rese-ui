<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>決済ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}" />
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
        <div class="payment">
            <div class="payment__head">
                <h1>こちらは決済ページです。</h1>
            </div>
            <div class="payment__text">
                <p>「決済する」ボタンを押してフォームを表示させ、必要な情報を入力してください。</p>
            </div>
            <div class="payment__form">
                <form action="{{ asset('pay') }}" method="POST">
                    {{ csrf_field() }}
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_51NjMYZHuosYE03blXTaFQPxuno5yZsJcyjw9F4x8jXwK7SgnWJHOD52SGcoRnLG8CJQPsPkchciE4EI5EjliMojw00o8XjGnDm"
                    data-amount="100"
                    data-name="Stripe決済デモ"
                    data-label="決済をする"
                    data-description="これはデモ決済です"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-currency="JPY">
                </script>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
