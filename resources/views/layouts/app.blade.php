<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'BookShelf')</title>

    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    @yield('css')
</head>

<body>

<header class="header">
    <div class="header__inner">
        <h1 class="header__logo">
            <a href="{{ route('home') }}">BookShelf</a>
        </h1>

        <nav class="header__nav">
            @auth
                <span>{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}">ログイン</a>
                <a href="{{ route('register') }}">会員登録</a>
            @endauth
        </nav>
    </div>
</header>

@if (session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif

@yield('content')

</body>

</html>