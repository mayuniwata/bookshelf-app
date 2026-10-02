@extends('layouts.app')

@section('title', 'ジャンル: ' . $genre->name)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/genres-show.css') }}">
@endsection

@section('content')

<div class="genre-heading">
    <div class="genre-heading__inner">
        ジャンル: {{ $genre->name }}
    </div>
</div>

<main class="genre-show-page">

    <div class="genre-show-container">

        {{-- 戻る --}}
        <div class="genre-back">
            <a href="{{ route('books.index') }}">
                ← 書籍一覧に戻る
            </a>
        </div>

        {{-- 書籍一覧 --}}
        <div class="genre-books-panel">

            @if ($books->isEmpty())

                <div class="genre-empty">
                    このジャンルの書籍はまだ登録されていません。
                </div>

            @else

                <div class="genre-books-grid">

                    @foreach ($books as $book)

                        <a
                            href="{{ route('books.show', $book) }}"
                            class="book-card"
                        >

                            {{-- 画像 --}}
                            <div class="book-card__image-area">

                                @if ($book->image_url)

                                    <img
                                        src="{{ $book->image_url }}"
                                        alt="{{ $book->title }}"
                                        class="book-card__image"
                                    >

                                @else

                                    <div class="book-card__no-image">
                                        {{ $book->id }}
                                    </div>

                                @endif

                            </div>

                            {{-- 情報 --}}
                            <div class="book-card__body">

                                <h2 class="book-card__title">
                                    {{ $book->title }}
                                </h2>

                                <p class="book-card__author">
                                    {{ $book->author }}
                                </p>

                                <div class="book-card__genres">

                                    @foreach ($book->genres as $g)

                                        <span class="genre-tag {{ $g->id === $genre->id ? 'is-current' : '' }}">
                                            {{ $g->name }}
                                        </span>

                                    @endforeach

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

                {{-- ページネーション --}}
                @if ($books->hasPages())
                    <div class="genre-pagination">
                        {{ $books->links() }}
                    </div>
                @endif

            @endif

        </div>

    </div>

</main>

@endsection