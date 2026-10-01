<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
{
    $books = Book::with('genres')
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->paginate(10);

    return view('books.index', compact('books'));
}

    public function create()
    {
        $genres = Genre::all();

        return view('books.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:255', 'unique:books,isbn'],
            'published_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['exists:genres,id'],
        ]);

        $book = Book::create([
            'user_id' => 1,
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'published_date' => $validated['published_date'],
            'description' => $validated['description'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
        ]);

        $book->genres()->sync($validated['genres'] ?? []);

        return redirect()
            ->route('books.index')
            ->with('success', '書籍を登録しました。');
    }

    public function show(Book $book)
{
    $book->load([
        'genres',
        'reviews.user',
    ]);

    $book->loadAvg('reviews', 'rating');
    $book->loadCount('reviews');

    return view('books.show', compact('book'));
}

    public function edit(Book $book)
{
    $genres = Genre::all();

    $book->load('genres');

    return view('books.edit', compact('book', 'genres'));
}

public function update(Request $request, Book $book)
{
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'author' => ['required', 'string', 'max:255'],
        'isbn' => ['required', 'string', 'max:255', 'unique:books,isbn,' . $book->id],
        'published_date' => ['required', 'date'],
        'description' => ['nullable', 'string'],
        'image_url' => ['nullable', 'url', 'max:255'],
        'genres' => ['nullable', 'array'],
        'genres.*' => ['exists:genres,id'],
    ]);

    $book->update([
        'title' => $validated['title'],
        'author' => $validated['author'],
        'isbn' => $validated['isbn'],
        'published_date' => $validated['published_date'],
        'description' => $validated['description'] ?? null,
        'image_url' => $validated['image_url'] ?? null,
    ]);


    $book->genres()->sync($validated['genres'] ?? []);

    return redirect()
        ->route('books.show', $book)
        ->with('success', '書籍情報を更新しました。');
}

public function destroy(Book $book)
{
    $book->delete();

    return redirect()
        ->route('books.index')
        ->with('success', '書籍を削除しました。');
}
}