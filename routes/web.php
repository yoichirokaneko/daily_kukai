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
Route::get('/admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('admin');

//ルーティング
Route::get('/', 'PostController@index')->name('index');
Route::post('/post', 'PostController@store')->middleware('auth');
Route::put('/post', 'PostController@point')->middleware('auth');
Route::get('/{post_id}/edit', 'PostController@edit')->name('post.edit')->middleware('auth');
Route::post('/{post_id}/edit', 'PostController@update')->middleware('auth');

//過去ログ
Route::get('/past', 'PastController@index')->name('pastlog')->middleware('auth');
Route::get('/past/{id}/{pagetitle}', 'PastController@show')->middleware('auth');

//管理人のルーティング
Route::get('/admin', 'AdminPostController@index')->name('admin.index')->middleware('admin');
Route::post('/admin/post', 'AdminPostController@store')->middleware('admin');
Route::put('/admin/post', 'AdminPostController@point');
Route::get('/admin/{post_id}/edit', 'AdminPostController@edit')->name('admin.post.edit')->middleware('admin');
Route::post('/admin/{post_id}/edit', 'AdminPostController@update')->middleware('admin');
Route::delete('/admin', 'AdminPostController@delete')->middleware('admin');
Route::get('/admin/{post_id}/comment', 'AdminCommentController@index')->name('admin.comment')->middleware('admin');
Route::post('/admin/{post_id}/comment', 'AdminCommentController@store')->middleware('admin');
Route::get('/admin/{post_id}/comment/{comment_id}', 'AdminCommentController@edit')->name('admin.comment.edit')->middleware('admin');
Route::post('admin/{post_id}/comment/{comment_id}', 'AdminCommentController@update')->middleware('admin');

//管理人の過去ログ
Route::get('/admin/past', 'AdminPastController@index')->name('admin.pastlog')->middleware('admin');
Route::get('/admin/past/{id}/{pagetitle}', 'AdminPastController@show')->middleware('admin');
