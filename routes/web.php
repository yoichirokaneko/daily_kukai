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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//ルーティング
Route::get('/', 'PostController@index')->name('index');
Route::post('/post', 'PostController@store')->middleware('auth');
Route::put('/post', 'PostController@point');
Route::get('/{post_id}/edit', 'PostController@edit')->name('post.edit');
// Route::post('/{post_id}/edit', 'PostController@update');

// //管理人のルーティング
// Route::get('/admin', 'AdminPostController@index')->name('admin.index');
// Route::delete('/admin', 'AdminPostController@delete');
// Route::get('/admin/{post_id}/comment', 'AdminCommentController@index');
// Route::post('/admin/{post_id}/comment', 'AdminCommentController@store');
// Route::get('/admin/{post_id}/comment/{comment_id}', 'AdminCommentController@edit')->name('admin.comment.edit');
// Route::post('admin/{post_id}/comment/{comment_id}', 'AdminCommentController@update');

// //過去ログのルーティング
// Route::get('/past');
// Route::get('/past/{page_id}');