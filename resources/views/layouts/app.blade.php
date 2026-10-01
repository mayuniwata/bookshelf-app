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
        <h1 class="header__logo">BookShelf</h1>
    </div>
</header>
@if (session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif

@yield('content')
@yield('content')

</body>

</html>
