@extends('layouts.app')

@section('title', 'お気に入り一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/books-index.css') }}">
@endsection

@section('content')

<main class="main">

    <div class="books-header">

        <h2 class="books-header__title">
            お気に入り一覧
        </h2>

        <a href="{{ route('books.index') }}">
            書籍一覧に戻る
        </a>

    </div>

    <div class="book-list">

        @forelse ($books as $book)

            <div class="book-card">

                <a href="{{ route('books.show', $book) }}">

                    <div class="book-card__image-area">

                        @if ($book->image_url)

                            <img
                                src="{{ $book->image_url }}"
                                alt="{{ $book->title }}"
                                class="book-card__image"
                            >

                        @else

                            <div class="book-card__no-image">
                                No Image
                            </div>

                        @endif

                    </div>

                    <div class="book-card__content">

                        <h3 class="book-card__title">
                            {{ $book->title }}
                        </h3>

                        <p class="book-card__author">
                            {{ $book->author }}
                        </p>

                        <div class="book-card__genres">

                            @foreach ($book->genres as $genre)

                                <span class="genre-tag">
                                    {{ $genre->name }}
                                </span>

                            @endforeach

                        </div>

                        <div class="book-card__rating">

                            @if ($book->reviews_count > 0)

                                ★ {{ number_format($book->reviews_avg_rating, 1) }}

                                <span>
                                    （{{ $book->reviews_count }}件）
                                </span>

                            @else

                                <span>
                                    まだ評価はありません
                                </span>

                            @endif

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <p>
                お気に入りの書籍はまだありません。
            </p>

        @endforelse

    </div>

    {{-- ページネーション --}}
    <div class="pagination">
        {{ $books->links() }}
    </div>

</main>

@endsection