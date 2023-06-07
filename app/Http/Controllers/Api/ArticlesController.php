<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Validator;

class ArticlesController extends Controller
{
    public function index()
    {

        $articles = Article::all();

        return response()->json($articles);
    }

    public function getById($id)
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

    public function create(Request $request)
    {

        $requestData = $request->only('title', 'content');

        $validator = Validator::make($requestData, [
            'title' => ['required', 'string'],      //min, max leng
            'content' => ['required', 'string']    //min, max leng
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
            'data' => $article
        ])->setStatusCode(201, 'Article added successfully'); //Code needs to be set, StatusCode - not necessarily
    }

    public function editPut($id, Request $request)
    {

        $requestData = $request->only('title', 'content');

        $validator = Validator::make($requestData, [
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

        $article->title = $requestData['title'];
        $article->content = $requestData['content'];

        $article->save();

        return response()->json([
            'status' => true,
            'message' => 'Article updated',
            'data' => $article
        ])->setStatusCode(200, 'Article updated');
    }

    public function editPatch($id, Request $request){

        $requestData = $request->only(['title', 'content']);

        if (count($requestData) === 0) {
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

        foreach ($requestData as $key => $data) {
            $rules[$key] = $rules_const[$key];
        }

        $validator = Validator::make($requestData, $rules);

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

        foreach ($requestData as $key => $data) {
            $article->$key = $data;
        }

        $article->save();

        return response()->json([
            "status" => true,
            "message" => "Article is updated"
        ])->setStatusCode(200, "Article is updated");

    }

    public function delete($id)
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
            "message" => "Article has deleted",
            "data" => $article
        ])->setStatusCode(200, 'Deleted');
    }
}
