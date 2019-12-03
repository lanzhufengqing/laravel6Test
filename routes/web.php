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

//微博 路由
Route::get('/', 'StaticPagesController@home');
Route::get('/help1', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');
Route::get('signup', 'UsersController@create')->name('signup');
Route::resource('users','UsersController');
Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout','SessionsController@destroy')->name('logout');
//邮箱激活确认
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');
//重置密码
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//微博
//resource 使用only 仅创建store（创建）、destory（删除） 两条路由
Route::resource('statuses','StatusesController',['only' =>  ['store','destroy']]);







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

//Route::get('/test/{param1}/{param2}', 'TestController@index');
Route::get('/test', 'TestController@index');
