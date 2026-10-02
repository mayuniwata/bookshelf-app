@extends('layouts.app')

@section('title', '評価ランキング TOP 10')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/ranking-index.css') }}">
@endsection

@section('content')

<div class="ranking-heading">
    <div class="ranking-heading__inner">
        評価ランキング TOP 10
    </div>
</div>

<main class="ranking-page">

    <div class="ranking-container">

        @if($rankedBooks->isEmpty())

            <div class="ranking-empty">
                まだレビューが投稿された書籍がありません。
            </div>

        @else

            <div class="ranking-list">

                @foreach($rankedBooks as $index => $book)

                    <a
                        href="{{ route('books.show', $book) }}"
                        class="ranking-item"
                    >

                        {{-- 順位 --}}
                        <div class="ranking-position
                            @if($index === 0) ranking-position--first
                            @elseif($index === 1) ranking-position--second
                            @elseif($index === 2) ranking-position--third
                            @endif
                        ">
                            {{ $index + 1 }}
                        </div>

                        {{-- 書籍画像 --}}
                        <div class="ranking-image">

                            @if($book->image_url)

                                <img
                                    src="{{ $book->image_url }}"
                                    alt="{{ $book->title }}"
                                >

                            @else

                                <div class="ranking-no-image">
                                    {{ $book->id }}
                                </div>

                            @endif

                        </div>

                        {{-- 書籍情報 --}}
                        <div class="ranking-info">

                            <h3 class="ranking-title">
                                {{ $book->title }}
                            </h3>

                            <p class="ranking-author">
                                {{ $book->author }}
                            </p>

                            <div class="ranking-stars">

                                @for($i = 1; $i <= 5; $i)

                                    @if($i <= round($book->reviews_avg_rating))
                                        <span class="star star--active">★</span>
                                    @else
                                        <span class="star">★</span>
                                    @endif

                                @endfor

                                <span class="ranking-rating">
                                    {{ number_format($book->reviews_avg_rating, 2) }}
                                </span>

                                <span class="ranking-reviews">
                                    ({{ $book->reviews_count }}件のレビュー)
                                </span>

                            </div>

                        </div>

                        {{-- 平均評価 --}}
                        <div class="ranking-score">

                            <div class="ranking-score__number">
                                {{ number_format($book->reviews_avg_rating, 1) }}
                            </div>

                            <div class="ranking-score__label">
                                平均評価
                            </div>

                        </div>

                    </a>

                @endforeach

            </div>

        @endif

    </div>

</main>

@endsection
