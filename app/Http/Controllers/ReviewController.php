<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        Review::create([
            'user_id' => 1,
            'book_id' => $book->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'レビューを投稿しました。');
    }

    public function destroy(Review $review)
{
    $book = $review->book;

    $review->delete();

    return redirect()
        ->route('books.show', $book)
        ->with('success', 'レビューを削除しました。');
}
}
