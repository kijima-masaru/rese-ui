<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>店舗代表者ページ</title>
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
                        <a href="{{ route('owner.index') }}">店舗情報の作成・更新</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner.reserve') }}">予約情報の確認</a>
                    </div>
                    <div class="header__url">
                        <a href="{{ route('owner.qrcode') }}">QRコードで予約検索</a>
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
                <h1>店舗情報を作成・更新できます。</h1>
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
            </div>
            <div class="owner__edit">
                <div class="edit__head">
                    <h2>店舗情報の修正</h2>
                </div>
                @foreach ($shops as $shop)
                    <div class="edit__card">
                        <div class="edit__form">
                            <form method="POST" action="{{ route('owner.update', $shop->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="img">現在の画像：</label>
                                    <img src="{{ asset('storage/' . $shop->img) }}" alt="Shop Image">
                                </div>
                                <div class="form-group">
                                    <label for="name">店舗名：</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $shop->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="area">エリア：</label>
                                    <input type="text" name="area" id="area" class="form-control" value="{{ old('area', $shop->area->area) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="genre">ジャンル：</label>
                                    <input type="text" name="genre" id="genre" class="form-control" value="{{ old('genre', $shop->genre->genre) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="overview">概要：</label>
                                    <textarea name="overview" id="overview" class="form-control" required>{{ old('overview', $shop->overview) }}</textarea>
                                </div>
                                <div class="edit__button">
                                    <button type="submit" class="btn btn-primary">更新</button>
                                </div>
                            </form>
                        </div>
                        <div class="img__edit">
                            <div class="img__form">
                                <form method="POST" action="{{ route('owner.update-image', $shop->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="new-img">新しい画像：</label>
                                        <input type="file" name="img" id="new-img" accept="image/*">
                                    </div>
                                    <div class="edit-image-button">
                                        <button type="submit" class="btn btn-primary">画像を更新する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</body>

</html>
