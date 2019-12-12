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

/*------------------- Auth -----------------------*/
Route::post('/token', 'Auth\LoginCOntroller@getToken');

/*------------------- User -----------------------*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*------------------- Question -----------------------*/
Route::get('/questions/{question}-{slug}', 'Api\QuestionDetailsController');
Route::get('/questions', 'Api\QuestionsController@index');
Route::middleware(['auth:api'])->group(function() {
    Route::apiResource('/questions', 'Api\QuestionsController')->except('index');
});





