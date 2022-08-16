<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticlesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Get complete list of the articles
Route::get('/articles', [ArticlesController::class, 'showArticles']);

//Get one selected article by ID
Route::get('/articles/{id}', [ArticlesController::class, 'showSingleArticle']);
