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

//Add new article
Route::post('/articles', [ArticlesController::class, 'storeArticle']);

//Edit article with PUT method
Route::put('/articles/{id}', [ArticlesController::class, 'editArticlePut']);

//Partial edit of one of the fields of the article with PATCH method
Route::patch('/articles/{id}', [ArticlesController::class, 'editArticlePatch']);

