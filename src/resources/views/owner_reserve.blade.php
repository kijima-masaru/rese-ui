<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>店舗予約確認ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/owner_reserve.css') }}" />
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
                        <a href="{{ route('owner.index') }}">店舗情報の作成・更新</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner.reserve') }}">予約情報の確認</a>
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
        <div class="owner__reserve">
            <div class="reserve__head">
                <h1>店舗の予約情報が確認できます。</h1>
            </div>
            <div class="reserve__table">
                @foreach ($shops as $shop)
                    <h2>{{ $shop->name }}</h2>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>日付：時間</th>
                                <th>人数</th>
                                <th>予約状況</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations[$shop->id] as $reservation)
                                <tr>
                                    <td>{{ $reservation->user->name }}</td>
                                    <td>{{ $reservation->time }}</td>
                                    <td>{{ $reservation->people }}人</td>
                                    <td>{{ $reservation->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </main>
</body>