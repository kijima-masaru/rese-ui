<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>管理者ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
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
        <div class="admin">
            <div class="container">
                <h1>ユーザー管理</h1>
                @if (session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('admin.searchUsers') }}" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="ユーザー名を検索">
                    <button type="submit">検索</button>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ユーザー名</th>
                            <th>役割</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <form action="{{ route('admin.updateRole', $user->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role">
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>admin</option>
                                        <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>owner</option>
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>user</option>
                                    </select>
                                    <button type="submit">更新</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>