<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>管理者店舗情報作成ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin_shop.css') }}" />
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
        <div class="admin__shop">
            <div class="admin__title">
                <h1>CSVファイルをアップロードして店舗情報を作成できます。</h1>
            </div>
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- フォームエラーメッセージ -->
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <div class="admin__new">
                <div class="new__form">
                    <form method="POST" action="{{ route('admin.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="csv_file" accept=".csv" required>
                        </div>
                        <div class="new__button">
                            <button type="submit" class="btn btn-primary">CSVファイルをインポート</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>