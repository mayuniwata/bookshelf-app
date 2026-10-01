<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * ジャンル一覧
     */
    public function index()
    {
        $genres = Genre::withCount('books')
            ->orderBy('name')
            ->get();

        return view('genres.index', compact('genres'));
    }

    /**
     * ジャンル詳細・そのジャンルの書籍一覧
     */
    public function show(Genre $genre)
    {
        $books = $genre->books()
            ->with('genres')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->paginate(10);

        return view('genres.show', compact('genre', 'books'));
    }

    /**
     * ジャンル作成画面
     */
    public function create()
    {
        return view('genres.create');
    }

    /**
     * ジャンル登録
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:genres,name'],
        ]);

        Genre::create($validated);

        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを登録しました。');
    }

    /**
     * ジャンル編集画面
     */
    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    /**
     * ジャンル更新
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:genres,name,' . $genre->id,
            ],
        ]);

        $genre->update($validated);

        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを更新しました。');
    }

    /**
     * ジャンル削除
     */
    public function destroy(Genre $genre)
    {
        if ($genre->books()->exists()) {
            return back()->with(
                'error',
                '書籍が登録されているジャンルは削除できません。'
            );
        }

        $genre->delete();

        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを削除しました。');
    }
}