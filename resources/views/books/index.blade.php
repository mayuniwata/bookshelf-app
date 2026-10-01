@extends('layouts.app')

@section('title', '書籍一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/books-index.css') }}">
@endsection

@section('content')

<main class="main">

    <div class="page-header">
        <h2 class="page-title">書籍一覧</h2>

        <a href="{{ route('books.create') }}" class="register-button">
            書籍を登録
        </a>
    </div>

    <div class="book-list">

        @forelse ($books as $book)

            <div class="book-card">

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

                <div class="book-card__body">

                    <h3 class="book-card__title">
    <a href="{{ route('books.show', $book) }}">
        {{ $book->title }}
    </a>
</h3>

                    <p class="book-card__author">
                        {{ $book->author }}
                    </p>
                    <div class="book-card__rating">

    @if ($book->reviews_count > 0)

        <span class="book-card__star">
            ★
        </span>

        <strong>
            {{ number_format($book->reviews_avg_rating, 1) }}
        </strong>

        <span class="book-card__review-count">
            （{{ $book->reviews_count }}件）
        </span>

    @else

        <span class="book-card__review-count">
            まだ評価はありません
        </span>

    @endif

</div>

                    <div class="book-card__genres">

                        @foreach ($book->genres as $genre)

                            <span class="genre-tag">
                                {{ $genre->name }}
                            </span>

                        @endforeach

                    </div>

                    <p class="book-card__date">
                        出版日：{{ $book->published_date }}
                    </p>

                </div>

            </div>

        @empty

            <div class="empty-message">
                まだ書籍が登録されていません。
            </div>

        @endforelse

    </div>

    <div class="pagination">
        {{ $books->links() }}
    </div>

</main>

@endsection