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
Route::get('/home/{date}', 'HomeController@index')->name('home');
Route::get('/review', 'HomeController@review')->name('review');
Route::get('/comment/{comment}', 'HomeController@comment')->name('comment');

// Comments
Route::get('/comments', 'CommentController@index');
Route::get('/comments/{date}', 'CommentController@getByDay');
Route::get('/comments/month/{month}', 'CommentController@getByMonth');
Route::post('/comments', 'CommentController@store');
Route::put('/comments/{comment}', 'CommentController@update');
Route::delete('/comments/{comment}', 'CommentController@destroy');
