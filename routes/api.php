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
Route::get('/articles', [ArticlesController::class, 'index']);

//Get one selected article by ID
Route::get('/articles/{id}', [ArticlesController::class, 'getById']);

//Add new article
Route::post('/articles', [ArticlesController::class, 'create']);

//Edit article with PUT method
Route::put('/articles/{id}', [ArticlesController::class, 'editPut']);

//Partial edit of one of the fields of the article with PATCH method
Route::patch('/articles/{id}', [ArticlesController::class, 'editPatch']);

//Delete one single article by ID
Route::delete('/articles/{id}', [ArticlesController::class, 'delete']);
