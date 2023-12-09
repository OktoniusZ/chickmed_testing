<?php

namespace App\Http\Controllers\Api;

//import Model "Article"
use App\Models\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "ArticleResources"
use App\Http\Resources\ArticleResource;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all articles
        $articles = Article::latest()->paginate(6);

        //return collection of articles as a resource
        return new ArticleResource(true, 'List Data Articles', $articles);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
            'author'    => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/articles', $image->hashName());

        //create article
        $article = Article::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
            'author'    => $request->author,
        ]);

        //return response
        return new ArticleResource(true, 'Data Article Berhasil Ditambahkan!', $article);
    }

    public function show($id)
    {
        //find article by ID
        $article = Article::find($id);

        //return single article as a resource
        return new ArticleResource(true, 'Detail Data article!', $article);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find article by ID
        $article = Article::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/articles', $image->hashName());

            //delete old image
            Storage::delete('public/articles/'.basename($article->image));

            //update article with new image
            $article->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content,
            ]);

        } else {

            //update article without image
            $article->update([
                'title'     => $request->title,
                'content'   => $request->content,
            ]);
        }

        //return response
        return new ArticleResource(true, 'Data Article Berhasil Diubah!', $article);
    }

    public function destroy($id)
    {

        //find article by ID
        $article = Article::find($id);

        //delete image
        Storage::delete('public/articles/'.basename($article->image));

        //delete article
        $article->delete();

        //return response
        return new ArticleResource(true, 'Data article Berhasil Dihapus!', null);
    }
}