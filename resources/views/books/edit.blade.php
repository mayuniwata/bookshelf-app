@extends('layouts.app')

@section('title', '書籍編集')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/books-edit.css') }}">
@endsection

@section('content')

<main class="main">

    <h2 class="page-title">書籍編集</h2>

    <div class="form-card">

        <form action="{{ route('books.update', $book) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">
                    タイトル
                    <span class="required">必須</span>
                </label>

                <input
                    type="text"
                    name="title"
                    class="form-input"
                    value="{{ old('title', $book->title) }}"
                >

                @error('title')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    著者
                    <span class="required">必須</span>
                </label>

                <input
                    type="text"
                    name="author"
                    class="form-input"
                    value="{{ old('author', $book->author) }}"
                >

                @error('author')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    ISBN
                    <span class="required">必須</span>
                </label>

                <input
                    type="text"
                    name="isbn"
                    class="form-input"
                    value="{{ old('isbn', $book->isbn) }}"
                >

                @error('isbn')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    出版日
                    <span class="required">必須</span>
                </label>

                <input
                    type="date"
                    name="published_date"
                    class="form-input"
                    value="{{ old('published_date', $book->published_date) }}"
                >

                @error('published_date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    画像URL
                </label>

                <input
                    type="url"
                    name="image_url"
                    class="form-input"
                    value="{{ old('image_url', $book->image_url) }}"
                    placeholder="https://..."
                >

                @error('image_url')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    ジャンル
                </label>

                <div class="genre-list">

                    @foreach ($genres as $genre)

                        <label class="genre-item">

                            <input
                                type="checkbox"
                                name="genres[]"
                                value="{{ $genre->id }}"
                                {{ in_array(
                                    $genre->id,
                                    old('genres', $book->genres->pluck('id')->toArray())
                                ) ? 'checked' : '' }}
                            >

                            {{ $genre->name }}

                        </label>

                    @endforeach

                </div>

                @error('genres')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    説明
                </label>

                <textarea
                    name="description"
                    class="form-textarea"
                >{{ old('description', $book->description) }}</textarea>

                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">

                <button type="submit" class="submit-button">
                    更新する
                </button>

                <a href="{{ route('books.show', $book) }}" class="back-button">
                    戻る
                </a>

            </div>

        </form>

    </div>

</main>

@endsection