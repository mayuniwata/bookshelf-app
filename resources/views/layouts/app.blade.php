<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BookShelf')</title>

    {{-- 共通CSS --}}
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    {{-- ページごとのCSS --}}
    @yield('css')

    {{-- Breeze / Alpine --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{-- 全画面共通ヘッダー --}}
    @include('layouts.navigation')


    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif


    {{-- エラーメッセージ --}}
    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif


    {{-- ページ内容 --}}
    @yield('content')


    @stack('scripts')

</body>

</html>