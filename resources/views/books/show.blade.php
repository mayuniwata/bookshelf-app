@extends('layouts.app')

@section('title', $book->title)

@section('css')
    <link rel="stylesheet" href="{{ asset('css/books-show.css') }}">
@endsection

@section('content')

<div class="detail-heading">
    <div class="detail-heading__inner">
        {{ $book->title }}
    </div>
</div>

<main class="book-show">

    <section class="book-panel">

        <div class="book-detail">

            {{-- 左：書影 --}}
            <div class="book-detail__image-area">
                @if ($book->image_url)
                    <img
                        src="{{ $book->image_url }}"
                        alt="{{ $book->title }}"
                        class="book-detail__image"
                    >
                @else
                    <div class="book-detail__no-image">
                        {{ $book->id }}
                    </div>
                @endif
            </div>

            {{-- 右：書籍情報 --}}
            <div class="book-detail__content">

                <div class="book-detail__top">
                    <h1 class="book-detail__title">
                        {{ $book->title }}
                    </h1>

                    @auth
                        <form
                            action="{{ route('favorites.toggle', $book) }}"
                            method="POST"
                            class="favorite-form"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="favorite-button {{ $book->favoritedByUsers->contains(auth()->id()) ? 'is-active' : '' }}"
                                title="お気に入り"
                            >
                                {{ $book->favoritedByUsers->contains(auth()->id()) ? '♥' : '♡' }}
                            </button>
                        </form>
                    @endauth
                </div>

                <div class="book-meta">

                    <p>
                        <strong>著者:</strong>
                        {{ $book->author }}
                    </p>

                    <p>
                        <strong>ISBN:</strong>
                        {{ $book->isbn }}
                    </p>

                    <p>
                        <strong>出版日:</strong>
                        {{ $book->published_date }}
                    </p>

                    <div class="book-meta__genres">
                        <strong>ジャンル:</strong>

                        <div class="genre-list">
                            @forelse ($book->genres as $genre)
                                <span class="genre-tag">
                                    {{ $genre->name }}
                                </span>
                            @empty
                                <span class="genre-empty">未設定</span>
                            @endforelse
                        </div>
                    </div>

                </div>

                <div class="book-description">
                    <strong>説明:</strong>

                    <p>
                        {{ $book->description ?? '説明はありません。' }}
                    </p>
                </div>

                @auth
                    @if ($book->user_id === auth()->id())
                        <div class="book-actions">

                            <a
                                href="{{ route('books.edit', $book) }}"
                                class="book-action book-action--edit"
                            >
                                編集
                            </a>

                            <form
                                action="{{ route('books.destroy', $book) }}"
                                method="POST"
                                onsubmit="return confirm('この書籍を削除してもよろしいですか？');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="book-action book-action--delete"
                                >
                                    削除
                                </button>
                            </form>

                        </div>
                    @endif
                @endauth

            </div>

        </div>

        {{-- レビュー --}}
        <div class="reviews">

            <h2 class="reviews__title">
                レビュー
            </h2>

            {{-- レビュー投稿 --}}
            @auth
                <div class="review-post">

                    <h3 class="review-post__title">
                        レビューを投稿
                    </h3>

                    <form
                        action="{{ route('reviews.store', $book) }}"
                        method="POST"
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
                                <option value="">選択してください</option>

                                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>
                                    ★★★★★
                                </option>

                                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>
                                    ★★★★☆
                                </option>

                                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>
                                    ★★★☆☆
                                </option>

                                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>
                                    ★★☆☆☆
                                </option>

                                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>
                                    ★☆☆☆☆
                                </option>
                            </select>

                            @error('rating')
                                <p class="form-error">
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
                                placeholder="この書籍の感想を書いてください"
                            >{{ old('comment') }}</textarea>

                            @error('comment')
                                <p class="form-error">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="review-form__submit">
                            <button
                                type="submit"
                                class="review-submit"
                            >
                                投稿する
                            </button>
                        </div>

                    </form>

                </div>
            @endauth

            {{-- レビュー一覧 --}}
            <div class="review-list">

                @forelse ($book->reviews as $review)

                    <article class="review-card">

                        <div class="review-card__top">

                            <div class="review-card__person">

                                <div class="review-card__name">
                                    {{ $review->user->name }}
                                </div>

                                <div class="review-card__stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">
                                            ★
                                        </span>
                                    @endfor
                                </div>

                            </div>

                            <time class="review-card__date">
                                {{ $review->created_at->format('Y/m/d') }}
                            </time>

                        </div>

                        <p class="review-card__comment">
                            {{ $review->comment }}
                        </p>

                        <div class="review-card__bottom">

                            <div class="review-card__like-area">

                                @auth
                                    <form
                                        action="{{ route('reviews.like', $review) }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="review-like {{ $review->likedByUsers->contains(auth()->id()) ? 'is-liked' : '' }}"
                                        >
                                            ♡
                                            {{ $review->likedByUsers->contains(auth()->id()) ? 'いいね済み' : 'いいね' }}
                                            ({{ $review->likedByUsers->count() }})
                                        </button>
                                    </form>
                                @else
                                    <span class="review-like review-like--guest">
                                        ♡ いいね ({{ $review->likedByUsers->count() }})
                                    </span>
                                @endauth

                            </div>

                            @auth
                                @if ($review->user_id === auth()->id())

                                    <div class="review-card__actions">

                                        <a
                                            href="{{ route('reviews.edit', $review) }}"
                                            class="review-edit"
                                        >
                                            編集
                                        </a>

                                        <form
                                            action="{{ route('reviews.destroy', $review) }}"
                                            method="POST"
                                            onsubmit="return confirm('このレビューを削除してもよろしいですか？');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="review-delete"
                                            >
                                                削除
                                            </button>

                                        </form>

                                    </div>

                                @endif
                            @endauth

                        </div>

                    </article>

                @empty

                    <div class="review-empty">
                        まだレビューはありません。
                    </div>

                @endforelse

            </div>

        </div>

    </section>

    <a
        href="{{ route('books.index') }}"
        class="back-link"
    >
        ← 一覧に戻る
    </a>

</main>

@endsection