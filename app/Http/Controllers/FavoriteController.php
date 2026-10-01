<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * お気に入り一覧
     */
    public function index()
    {
        $books = auth()->user()
            ->favoriteBooks()
            ->with('genres')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->paginate(10);

        return view('favorites.index', compact('books'));
    }

    /**
     * お気に入り追加・解除
     */
    public function toggle(Book $book)
    {
        $user = auth()->user();

        if ($book->favoritedByUsers()
            ->where('users.id', $user->id)
            ->exists()) {

            $book->favoritedByUsers()->detach($user->id);

            return back()->with('success', 'お気に入りから解除しました。');
        }

        $book->favoritedByUsers()->attach($user->id);

        return back()->with('success', 'お気に入りに追加しました。');
    }
}