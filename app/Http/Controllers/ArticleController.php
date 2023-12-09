<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $article = Article::orderBy("id", "desc");

        if ($query) {
            $article->where('title', 'like', "%{$query}%");
        }

        $article = $article->paginate(5);

        $filterValues = [];
        if ($query) {
            $filterValues['search'] = $query;
        }

        $article->appends($filterValues);

        return Inertia::render("Dashboard", [
            "data" => $article,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|max:5120',
        ]);

        $article = new Article();
        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];
        $image = $request->file('image');
        $image->storeAs('public/articles', $image->hashName());
        $article->image = $image->hashName();
        $article->author = auth()->user()->email;
        $article->save();
        return redirect()->back()->with('message', 'Update artikel berhasil');
    }

    public function delete(Request $request, $id)
    {
        $data = Article::find($id);
        $data->delete();
        return redirect()->route('dashboard')->with('success', 'Data Berhasil Dihapus');
    }

    public function edit(Article $articles, Request $request)
    {
        return Inertia::render('EditArticles', [
            'articles' => $articles->find($request->id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/articles', $image->hashName());
            $article->image = $image->hashName();
        }
        $article->save();

        return to_route('dashboard')->with('message', 'Update artikel berhasil');
    }
}
