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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionsController')->except('show');
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');
// vì sao except hàm index, show, create trong controller
// index: dùng cho show tất cả, hàm show dùng cho show detail, hàm create dùng cho show form trước khi create
// các hàm trên không cần thiết
Route::resource('questions.answers', 'AnswersController')->except(['index', 'show', 'create']);
//Route::post('/questions/{question}/answers', 'AnswerController@store')->name('answers.store');
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

Route::post('/questions/{question}/vote', 'VoteQuestionController');
