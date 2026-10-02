@extends('layouts.app')

@section('title', 'レビューの編集')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reviews-edit.css') }}">
@endsection

@section('content')

<div class="review-edit-heading">
    <div class="review-edit-heading__inner">
        レビューの編集
    </div>
</div>

<main class="review-edit-page">

    <div class="review-edit-card">

        <form
            action="{{ route('reviews.update', $review) }}"
            method="POST"
            novalidate
        >
            @csrf
            @method('PUT')

            {{-- 書籍名 --}}
            <div class="book-name">
                <span class="book-name__label">書籍:</span>
                <span class="book-name__title">
                    {{ $review->book->title }}
                </span>
            </div>

            {{-- 評価 --}}
            <div class="form-group">

                <p class="form-label">
                    評価 <span class="required">*</span>
                </p>

                <div class="rating-input">

                    @for ($i = 1; $i <= 5; $i++)

                        <label class="rating-item">

                            <input
                                type="radio"
                                name="rating"
                                value="{{ $i }}"
                                {{ old('rating', $review->rating) == $i ? 'checked' : '' }}
                            >

                            <span class="rating-star">
                                ★
                            </span>

                        </label>

                    @endfor

                </div>

                @error('rating')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- コメント --}}
            <div class="form-group">

                <label
                    for="comment"
                    class="form-label"
                >
                    コメント
                </label>

                <textarea
                    name="comment"
                    id="comment"
                    class="form-textarea"
                    rows="5"
                >{{ old('comment', $review->comment) }}</textarea>

                @error('comment')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- ボタン --}}
            <div class="form-actions">

                <a
                    href="{{ route('books.show', $review->book) }}"
                    class="cancel-button"
                >
                    キャンセル
                </a>

                <button
                    type="submit"
                    class="submit-button"
                >
                    更新する
                </button>

            </div>

        </form>

    </div>

</main>

@endsection
