@extends('layouts.app')

@section('title', $book->title)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/books-show.css') }}">
@endsection

@section('content')

<main class="main">

    {{-- 書籍詳細 --}}
    <div class="book-detail">

        <div class="book-detail__image-area">

            @if ($book->image_url)

                <img
                    src="{{ $book->image_url }}"
                    alt="{{ $book->title }}"
                    class="book-detail__image"
                >

            @else

                <div class="book-detail__no-image">
                    No Image
                </div>

            @endif

        </div>

        <div class="book-detail__content">

            <h2 class="book-detail__title">
                {{ $book->title }}
            </h2>

            <p class="book-detail__author">
                {{ $book->author }}
            </p>

            <div class="book-detail__rating">

    @if ($book->reviews_count > 0)

        <span class="book-detail__stars">
            ★
        </span>

        <strong>
            {{ number_format($book->reviews_avg_rating, 1) }}
        </strong>

        <span class="book-detail__review-count">
            （{{ $book->reviews_count }}件のレビュー）
        </span>

    @else

        <span class="book-detail__review-count">
            まだ評価はありません
        </span>

    @endif

</div>

            <div class="book-detail__genres">

                @foreach ($book->genres as $genre)

                    <span class="genre-tag">
                        {{ $genre->name }}
                    </span>

                @endforeach

            </div>

            <dl class="book-info">

                <div class="book-info__row">
                    <dt>ISBN</dt>
                    <dd>{{ $book->isbn }}</dd>
                </div>

                <div class="book-info__row">
                    <dt>出版日</dt>
                    <dd>{{ $book->published_date }}</dd>
                </div>

            </dl>

            <div class="book-description">

                <h3>書籍紹介</h3>

                <p>
                    {{ $book->description ?? '説明はありません。' }}
                </p>

            </div>

            <div class="book-actions">

                <a href="{{ route('books.index') }}" class="back-button">
                    一覧に戻る
                </a>

                <a href="{{ route('books.edit', $book) }}" class="edit-button">
                    編集する
                </a>

                <form
                    action="{{ route('books.destroy', $book) }}"
                    method="POST"
                    onsubmit="return confirm('この書籍を削除してもよろしいですか？');"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="delete-button">
                        削除する
                    </button>

                </form>

            </div>

        </div>

    </div>


    {{-- レビュー投稿 --}}
    <section class="review-section">

        <h2 class="review-section__title">
            レビューを投稿
        </h2>

        <form
            action="{{ route('reviews.store', $book) }}"
            method="POST"
            class="review-form"
        >
            @csrf

            <div class="review-form__group">

                <label for="rating">
                    評価
                </label>

                <select
                    name="rating"
                    id="rating"
                    class="review-form__select"
                >
                    <option value="">
                        選択してください
                    </option>

                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>
                        ★★★★★ 5
                    </option>

                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>
                        ★★★★☆ 4
                    </option>

                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>
                        ★★★☆☆ 3
                    </option>

                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>
                        ★★☆☆☆ 2
                    </option>

                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>
                        ★☆☆☆☆ 1
                    </option>

                </select>

                @error('rating')
                    <p class="error-message">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="review-form__group">

                <label for="comment">
                    コメント
                </label>

                <textarea
                    name="comment"
                    id="comment"
                    class="review-form__textarea"
                    placeholder="この本の感想を書いてください"
                >{{ old('comment') }}</textarea>

                @error('comment')
                    <p class="error-message">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <button
                type="submit"
                class="review-form__button"
            >
                レビューを投稿
            </button>

        </form>

    </section>

    {{-- レビュー一覧 --}}
<section class="review-list-section">

    <h2 class="review-section__title">
        みんなのレビュー
    </h2>

    @forelse ($book->reviews as $review)

        <div class="review-card">

            <div class="review-card__header">

                <span class="review-card__user">
                    {{ $review->user->name }}
                </span>

                <span class="review-card__rating">
                    @for ($i = 1; $i <= 5; $i++)
                        {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                </span>

            </div>

            <p class="review-card__comment">
                {{ $review->comment }}
            </p>

            <p class="review-card__date">
                {{ $review->created_at->format('Y/m/d') }}
            </p>
            <form
    action="{{ route('reviews.destroy', $review) }}"
    method="POST"
    onsubmit="return confirm('このレビューを削除してもよろしいですか？');"
>
    @csrf
    @method('DELETE')

    <button type="submit" class="review-card__delete">
        削除
    </button>
</form>

        </div>

    @empty

        <p class="review-empty">
            まだレビューはありません。
        </p>

    @endforelse

</section>

</main>

@endsection