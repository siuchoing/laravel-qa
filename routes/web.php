<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*------------------- Auth -----------------------*/
Auth::routes(['verify' => true]);    // Email Verification Routes by passing the verify option to the Auth::routes method

/*------------------- Single Page -----------------------*/
Route::view('/{any}', 'spa')->where('any', '.*');   // return all view to 'spa' view,

/*------------------- Home -----------------------*/
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

/*------------------- Question -----------------------*/
Route::get('/', 'QuestionsController@index');
Route::resource('questions', 'QuestionsController')->except('show');
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');
Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');
Route::post('/questions/{question}/vote', 'VoteQuestionController');

/*------------------- Answer -------------------------*/
//Route::post('/questions/{question}/answers', 'AnswersController@store')->name('answers.store');
Route::resource('questions.answers', 'AnswersController')->except(['create', 'show']);
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');
Route::post('/answers/{answer}/vote', 'VoteAnswerController');

/*------------------- Exercise -------------------------*/
//Route::get('/lesson-5/questions', 'QuestionsController@index_lesson5');
