<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function showArticles() {
        $articles = Article::all();
        return response()->json($articles);
    }

    public function showSingleArticle ($id) {
        $article = Article::find($id);
        return response()->json($article);
    }
}
