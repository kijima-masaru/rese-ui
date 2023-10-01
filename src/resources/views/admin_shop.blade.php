<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>管理者店舗情報作成ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}" />
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
                        <a href="{{ route('admin.index') }}">管理者ページ</a>
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
        <div class="owner">
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="owner__title">
                <h1>店舗情報を作成できます。</h1>
            </div>
            <div class="owner__new">
                <div class="new__head">
                    <h2>店舗情報の新規作成</h2>
                </div>
                <div class="new__form">
                    <form method="POST" action="{{ route('owner.store') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label for="name">店舗名：</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="area">エリア：</label>
                            <input type="text" name="area" id="area" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="genre">ジャンル：</label>
                            <input type="text" name="genre" id="genre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="overview">概要：</label>
                            <textarea name="overview" id="overview" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="img">画像：</label>
                            <input type="file" name="img" accept="image/*">
                        </div>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <div class="new__button">
                            <button type="submit" class="btn btn-primary">店舗情報を作成する</button>
                        </div>
                    </form>
                </div>
                <div class="new__form">
                    <form method="POST" action="{{ route('admin.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file">CSVファイルをアップロード：</label>
                            <input type="file" name="csv_file" accept=".csv" required>
                        </div>
                        <div class="new__button">
                            <button type="submit" class="btn btn-primary">CSVをインポート</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>