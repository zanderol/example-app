<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Validator;

class ArticlesController extends Controller
{
    public function showArticles()
    {

        $articles = Article::all();

        return response()->json($articles);
    }

    public function showSingleArticle($id)
    {

        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                "status" => false,
                "message" => "Article not found"
            ])->setStatusCode(404, 'Article not found'); //not necessary minor update
        }

        return response()->json($article);
    }

    public function storeArticle(Request $request)
    {

        $request_data = $request->only('title', 'content');

        $validator = Validator::make($request_data, [
            'title' => ['required', 'string'],
            'content' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->messages()
            ])->setStatusCode(422);
        }

        $article = Article::create([

            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Article added',
            'article' => $article
        ])->setStatusCode(201, 'Article added successfully'); //Code needs to be set, StatusCode - not necessarily
    }

    public function editArticlePut($id, Request $request)
    {

        $request_data = $request->only('title', 'content');

        $validator = Validator::make($request_data, [
            'title' => ['required', 'string'],
            'content' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->messages()
            ])->setStatusCode(422);
        }

        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'status' => false,
                'message' => 'Article not found'
            ])->setStatusCode(404, 'Article not found');
        }

        $article->title = $request_data['title'];
        $article->content = $request_data['content'];

        $article->save();

        return response()->json([
           'status' => true,
           'message' => 'Article updated'
        ])->setStatusCode(200, 'Article updated');
    }
}
