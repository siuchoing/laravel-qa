<?php

use Illuminate\Http\Request;

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

// routes/api.php
Route::apiResource('/questions', 'Api\QuestionsController')->except('index')->middleware('auth:api');
Route::post('/token', 'Auth\LoginCOntroller@getToken');
Route::get('/questions', 'Api\QuestionsController@index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
