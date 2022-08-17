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

    public function editArticlePatch($id, Request $request){

        $request_data = $request->only(['title', 'content']);

        if (count($request_data) === 0) {
            return response()->json([
                "status" => false,
                "message" => "All fields are empty"
            ])->setStatusCode(422, "All fields are empty");
        }

        $rules_const = [
            "title" => ['required', 'string'],
            "content" => ['required', 'string']
        ];


        $rules = [];

        foreach ($request_data as $key => $data) {
            $rules[$key] = $rules_const[$key];
        }

        $validator = Validator::make($request_data, $rules);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->messages()
            ])->setStatusCode(422);
        }

        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                "status" => false,
                "message" => "Article not found"
            ])->setStatusCode(404, "Article not found");
        }

        foreach ($request_data as $key => $data) {
            $article->$key = $data;
        }

        $article->save();

        return response()->json([
            "status" => true,
            "message" => "Article is updated"
        ])->setStatusCode(200, "Article is updated");

    }

    public function deleteArticle($id)
    {

        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                "status" => false,
                "message" => "Article not found"
            ])->setStatusCode(404, 'Article not found'); //not necessary minor update
        }

        $article->delete();

        return response()->json([
            "status" => true,
            "message" => "Article has deleted"
        ])->setStatusCode(404, 'Deleted');
    }
}

