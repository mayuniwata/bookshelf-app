<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * 書籍一覧API
     */
    public function index(Request $request)
    {
        $query = Book::with('genres')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('author', 'like', "%{$keyword}%")
                    ->orWhere('isbn', 'like', "%{$keyword}%");
            });
        }

        // ジャンル絞り込み
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }

        $books = $query->paginate(10);

        return BookResource::collection($books);
    }

    /**
     * 書籍登録API
     */
     public function store(Request $request)
{
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'author' => ['required', 'string', 'max:255'],
        'isbn' => ['required', 'string', 'max:13', 'unique:books,isbn'],
        'published_date' => ['required', 'date'],
        'description' => ['required', 'string'],
        'image_url' => ['required', 'url', 'max:255'],
        'genres' => ['nullable', 'array'],
        'genres.*' => ['exists:genres,id'],
    ]);

    $book = Book::create([
        'user_id' => 1,
        'title' => $validated['title'],
        'author' => $validated['author'],
        'isbn' => $validated['isbn'],
        'published_date' => $validated['published_date'],
        'description' => $validated['description'],
        'image_url' => $validated['image_url'],
    ]);

    $book->genres()->sync($validated['genres'] ?? []);

    $book->load('genres');
    $book->loadAvg('reviews', 'rating');
    $book->loadCount('reviews');

    return (new BookResource($book))
        ->response()
        ->setStatusCode(201);
}

    /**
     * 書籍詳細API
     */
    public function show(Book $book)
{
    $book->load([
        'genres',
        'reviews.user',
    ]);

    $book->loadAvg('reviews', 'rating');
    $book->loadCount('reviews');

    return new BookResource($book);
}


    /**
     * 書籍更新API
     */
   public function update(Request $request, Book $book)
{
    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'author' => ['required', 'string', 'max:255'],
        'isbn' => [
            'required',
            'string',
            'max:13',
            'unique:books,isbn,' . $book->id,
        ],
        'published_date' => ['required', 'date'],
        'description' => ['required', 'string'],
        'image_url' => ['required', 'url', 'max:255'],
        'genres' => ['nullable', 'array'],
        'genres.*' => ['exists:genres,id'],
    ]);

    $book->update([
        'title' => $validated['title'],
        'author' => $validated['author'],
        'isbn' => $validated['isbn'],
        'published_date' => $validated['published_date'],
        'description' => $validated['description'],
        'image_url' => $validated['image_url'],
    ]);

    $book->genres()->sync($validated['genres'] ?? []);

    $book->load('genres');
    $book->loadAvg('reviews', 'rating');
    $book->loadCount('reviews');

    return new BookResource($book);
}

    /**
     * 書籍削除API
     */
    public function destroy(Book $book)
{
    $book->delete();

    return response()->json([
        'message' => '書籍を削除しました。',
    ], 200);
}
}