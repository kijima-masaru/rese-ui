<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>管理者口コミ閲覧・削除用ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin_review.css') }}" />
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
                        <a href="{{ route('admin.index') }}">ユーザー管理</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('admin.reviews.index') }}">口コミ一覧</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('admin.shop.index') }}">店舗情報の作成</a>
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
        <div class="admin__review">
            <h1>口コミ一覧</h1>
            <div class="search-form">
                <form action="{{ route('admin.reviews.search') }}" method="GET">
                    <div class="form-group">
                        <input type="text" name="user_name" placeholder="ユーザー名で検索">
                        <button type="submit">検索</button>
                    </div>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ユーザー</th>
                        <th>店舗</th>
                        <th>評価</th>
                        <th>コメント</th>
                        <th>画像</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->user->name }}</td>
                            <td>{{ $review->shop->name }}</td>
                            <td>{{ $review->rating }}</td>
                            <td>{{ $review->comment }}</td>
                            <td>
                                @if ($review->img)
                                    <img src="{{ asset('storage/' . $review->img) }}" alt="レビュー画像" width="100">
                                @else
                                    画像なし
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.reviews.destroy', ['review' => $review->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>