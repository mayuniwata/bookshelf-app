@extends('layouts.app')

@section('title', 'ジャンル編集')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/genres-create.css') }}">
@endsection

@section('content')

<div class="genre-create-heading">
    <div class="genre-create-heading__inner">
        ジャンル編集
    </div>
</div>

<main class="genre-create-page">

    <div class="genre-create-card">

        <form
            action="{{ route('genres.update', $genre) }}"
            method="POST"
            novalidate
        >
            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="name" class="form-label">
                    ジャンル名
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $genre->name) }}"
                    class="form-input"
                >

                @error('name')
                    <p class="form-error">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="form-actions">

                <a
                    href="{{ route('genres.index') }}"
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