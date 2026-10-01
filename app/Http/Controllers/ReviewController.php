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
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'レビューを投稿しました。');
    }

    public function edit(Review $review)
    {
        abort_unless($review->user_id === auth()->id(), 403);

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        abort_unless($review->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $review->update($validated);

        return redirect()
            ->route('books.show', $review->book)
            ->with('success', 'レビューを更新しました。');
    }

    public function destroy(Review $review)
    {
        abort_unless($review->user_id === auth()->id(), 403);

        $book = $review->book;

        $review->delete();

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'レビューを削除しました。');
    }

    public function like(Review $review)
    {
        $user = auth()->user();

        if ($review->likedByUsers()->where('users.id', $user->id)->exists()) {
            $review->likedByUsers()->detach($user->id);
        } else {
            $review->likedByUsers()->attach($user->id);
        }

        return back();
    }
}

