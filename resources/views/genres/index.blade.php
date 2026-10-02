@extends('layouts.app')

@section('title', 'ジャンル管理')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/genres-index.css') }}">
@endsection

@section('content')

<div class="genre-heading">
    <div class="genre-heading__inner">
        ジャンル管理
    </div>
</div>

<main class="genre-page">

    <div class="genre-container">

        {{-- ジャンル登録ボタン --}}
        <div class="genre-create">
            <a
                href="{{ route('genres.create') }}"
                class="genre-create__button"
            >
                ジャンルを登録
            </a>
        </div>

        {{-- 成功メッセージ --}}
        @if (session('success'))
            <div class="genre-message genre-message--success">
                {{ session('success') }}
            </div>
        @endif

        {{-- エラーメッセージ --}}
        @if (session('error'))
            <div class="genre-message genre-message--error">
                {{ session('error') }}
            </div>
        @endif

        {{-- ジャンル一覧 --}}
        <div class="genre-card">

            @if ($genres->isEmpty())

                <p class="genre-empty">
                    ジャンルが登録されていません。
                </p>

            @else

                <table class="genre-table">

                    <thead>
                        <tr>
                            <th>ジャンル名</th>
                            <th>書籍数</th>
                            <th>操作</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($genres as $genre)

                            <tr>

                                {{-- ジャンル名 --}}
                                <td>
                                    <a
                                        href="{{ route('genres.show', $genre) }}"
                                        class="genre-name"
                                    >
                                        {{ $genre->name }}
                                    </a>
                                </td>

                                {{-- 書籍数 --}}
                                <td class="genre-count">
                                    {{ $genre->books_count }}冊
                                </td>

                                {{-- 操作 --}}
                                <td>
                                    <div class="genre-actions">

                                        <a
                                            href="{{ route('genres.edit', $genre) }}"
                                            class="genre-edit"
                                        >
                                            編集
                                        </a>

                                        <form
                                            action="{{ route('genres.destroy', $genre) }}"
                                            method="POST"
                                            onsubmit="return confirm('本当に削除しますか？');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="genre-delete"
                                            >
                                                削除
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @endif

        </div>

    </div>

</main>

@endsection