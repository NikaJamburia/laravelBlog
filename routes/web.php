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

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::resource('posts', 'PostsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/posts/{post}/like', 'PostsController@addLike');
Route::post('/posts/{post}/unlike', 'PostsController@removeLike');
Route::post('/posts/{post}', 'PostsController@addComment');
Route::post('/posts/{post}/reply', 'PostsController@addReply');

Route::get('/posts/category/{category}', 'PostsController@ShowByCategory');

Route::get('/admin/categories', 'CategoriesController@index');
Route::post('/admin/categories', 'CategoriesController@store');
Route::delete('/admin/categories', 'CategoriesController@delete');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/posts', 'AdminController@posts');
Route::get('/admin/comments', 'AdminController@comments');
Route::get('/admin/users', 'AdminController@users');
Route::delete('/admin/comments/{comment}', 'AdminController@deleteComment');
Route::post('/admin/users/makeadmin/{user}', 'AdminController@addAdmin');
Route::post('/admin/users/removeadmin/{user}', 'AdminController@removeAdmin');
