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

Route::get('/', 'VideoController@index')->name('video.index');
// Route::get('/', function () {
//     return view('layouts.app');
// });
Route::get('/register','RegisterController@register')->name('register');
Route::post('user-store', 'RegisterController@store')->name('user.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/create-video','VideoController@create')->name('video.create');
Route::post('/store-video','VideoController@store')->name('video.store');
Route::get('/edit-video/{video_id}', 'VideoController@edit')->name('edit.video');
Route::put('/update-video/{video_id}', 'VideoController@update')->name('update.video');
Route::delete('/delete-video/{video_id}', 'VideoController@destroy')->name('delete.video');
Route::get('/get-image/{image_name}','VideoController@getImage')->name('get.image');
Route::get('/get-avatar/{avatar_name}','RegisterController@getAvatar')->name('get.avatar');
Route::get('/play-video/{video_id}','VideoController@playVideo')->name('play.video');

Route::get('/get-video/{video_path}','VideoController@getVideo')->name('get.video');

Route::post('/create-comment/', 'VideoController@createComment')->name('create.comment');