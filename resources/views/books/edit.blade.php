@extends('layouts.app')

@section('title', '書籍の編集')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/books-edit.css') }}">
@endsection

@section('content')

<div class="edit-heading">
    <div class="edit-heading__inner">
        書籍の編集
    </div>
</div>

<main class="edit-page">

    <div class="edit-card">

        <form action="{{ route('books.update', $book) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- タイトル --}}
            <div class="form-group">
                <label for="title" class="form-label">
                    タイトル <span class="required">*</span>
                </label>

                <input
                    id="title"
                    type="text"
                    name="title"
                    class="form-input"
                    value="{{ old('title', $book->title) }}"
                >

                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 著者 --}}
            <div class="form-group">
                <label for="author" class="form-label">
                    著者 <span class="required">*</span>
                </label>

                <input
                    id="author"
                    type="text"
                    name="author"
                    class="form-input"
                    value="{{ old('author', $book->author) }}"
                >

                @error('author')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- ISBN --}}
            <div class="form-group">
                <label for="isbn" class="form-label">
                    ISBN-13 <span class="required">*</span>
                </label>

                <input
                    id="isbn"
                    type="text"
                    name="isbn"
                    class="form-input"
                    value="{{ old('isbn', $book->isbn) }}"
                    maxlength="13"
                >

                <p class="form-help">
                    13桁のISBNコードを入力してください
                </p>

                @error('isbn')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 出版日 --}}
            <div class="form-group">
                <label for="published_date" class="form-label">
                    出版日 <span class="required">*</span>
                </label>

                <input
                    id="published_date"
                    type="date"
                    name="published_date"
                    class="form-input"
                    value="{{ old('published_date', $book->published_date) }}"
                >

                @error('published_date')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 説明 --}}
            <div class="form-group">
                <label for="description" class="form-label">
                    説明
                </label>

                <textarea
                    id="description"
                    name="description"
                    class="form-textarea"
                    rows="5"
                >{{ old('description', $book->description) }}</textarea>

                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 画像URL --}}
            <div class="form-group">
                <label for="image_url" class="form-label">
                    画像URL
                </label>

                <input
                    id="image_url"
                    type="url"
                    name="image_url"
                    class="form-input"
                    value="{{ old('image_url', $book->image_url) }}"
                    placeholder="https://example.com/image.jpg"
                >

                <p class="form-help">
                    書籍の表紙画像のURLを入力してください（任意）
                </p>

                @error('image_url')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- ジャンル --}}
            <div class="form-group">
                <p class="form-label">
                    ジャンル <span class="required">*</span>
                </p>

                <div class="genre-box">

                    @foreach ($genres as $genre)

                        <label class="genre-item">

                            <input
                                type="checkbox"
                                name="genres[]"
                                value="{{ $genre->id }}"
                                {{ in_array(
                                    $genre->id,
                                    old(
                                        'genres',
                                        $book->genres->pluck('id')->toArray()
                                    )
                                ) ? 'checked' : '' }}
                            >

                            <span>{{ $genre->name }}</span>

                        </label>

                    @endforeach

                </div>

                @error('genres')
                    <p class="form-error">{{ $message }}</p>
                @enderror

                @error('genres.*')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- ボタン --}}
            <div class="form-actions">

                <a
                    href="{{ route('books.show', $book) }}"
                    class="cancel-button"
                >
                    キャンセル
                </a>

                <button
                    type="submit"
                    class="submit-button"
                >
                    更新
                </button>

            </div>

        </form>

    </div>

</main>

@endsection