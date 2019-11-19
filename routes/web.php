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
Route::get('/hello', function () {
    return "hello world";
});
//resource 
Route::resource('articles', 'ArticlesController');

/*Route::get('/articles', 'ArticlesController@index')->name('articles.index'); //列表页
Route::get('/articles/{id}', 'ArticlesController@show')->name('articles.show'); //单条详情页
Route::get('/articles/create', 'ArticlesController@create')->name('articles.create'); //添加页面
Route::post('/articles', 'ArticlesController@store')->name('articles.store'); //添加操作
Route::get('/articles/{id}/edit', 'ArticlesController@edit')->name('articles.edit'); //修改页面
Route::patch('/articles/{id}', 'ArticlesController@update')->name('articles.update'); //修改操作
Route::delete('/articles/{id}', 'ArticlesController@destroy')->name('articles.destroy'); //删除操作
*/

Route::get('/test/{param1}/{param2}', 'TestController@index');