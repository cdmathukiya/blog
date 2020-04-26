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

Route::get('/home', 'PostController@index')->name('home');
Route::get('/create/{id?}', 'PostController@create')->name('create_post');
Route::post('/load', 'PostController@loadPost')->name('load_post');
Route::post('/save', 'PostController@save')->name('save_post');
Route::get('/post/delete/{id}', 'PostController@delete')->name('delete_post');
