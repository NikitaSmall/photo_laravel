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

// Route::get('/', 'PhotosController@index')->name('photos');

Route::get('/', 'CategoriesController@index')->name('home');
Route::get('/categories/{id}', 'CategoriesController@show')->name('category');

Route::post('/categories', 'CategoriesController@create')->name('createCategory');
Route::post('/photos', 'PhotosController@create')->name('createPhoto');
