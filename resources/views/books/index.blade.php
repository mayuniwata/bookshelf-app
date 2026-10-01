@extends('layouts.app')

@section('title', '書籍一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/books-index.css') }}">
@endsection

@section('content')

<div class="page-heading">
    <div class="page-heading__inner">
        <h2 class="page-title">書籍一覧</h2>
    </div>
</div>

<main class="books-page">

    <div class="books-container">

        {{-- 書籍登録ボタン --}}
        @auth
            <div class="books-create">
                <a href="{{ route('books.create') }}" class="books-create__button">
                    書籍を登録
                </a>
            </div>
        @endauth


        {{-- 書籍一覧 --}}
        <div class="books-panel">

            <div class="books-grid">

                @forelse ($books as $book)

                    <article class="book-card">

                        <a
                            href="{{ route('books.show', $book) }}"
                            class="book-card__image-link"
                        >

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

                        </a>


                        <div class="book-card__body">

                            <h3 class="book-card__title">

                                <a href="{{ route('books.show', $book) }}">
                                    {{ $book->title }}
                                </a>

                            </h3>


                            <p class="book-card__author">
                                {{ $book->author }}
                            </p>


                            {{-- 評価 --}}
                            @if ($book->reviews_count > 0)

                                <div class="book-card__rating">

                                    <span class="book-card__stars">
                                        ★
                                    </span>

                                    <span>
                                        {{ number_format($book->reviews_avg_rating, 1) }}
                                    </span>

                                    <span class="book-card__review-count">
                                        ({{ $book->reviews_count }})
                                    </span>

                                </div>

                            @endif


                            {{-- ジャンル --}}
                            <div class="book-card__genres">

                                @foreach ($book->genres as $genre)

                                    <span class="book-card__genre">
                                        {{ $genre->name }}
                                    </span>

                                @endforeach

                            </div>


                            {{-- 出版日 --}}
                            @if ($book->published_date)

                                <p class="book-card__date">
                                    {{ $book->published_date }}
                                </p>

                            @endif

                        </div>

                    </article>

                @empty

                    <p class="books-empty">
                        登録されている書籍はありません。
                    </p>

                @endforelse

            </div>


            {{-- ページネーション --}}
            @if ($books->hasPages())

                <div class="books-pagination">
                    {{ $books->links() }}
                </div>

            @endif

        </div>

    </div>

</main>

@endsection