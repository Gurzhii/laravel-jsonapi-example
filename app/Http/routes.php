<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//
//Route::group(['middleware' => ['web'], 'prefix' => 'api'], function () {
//    Route::resource('books', 'api\BooksController');
//});

Route::group(['namespace' => 'Api', 'prefix' => 'api'], function () {
    Route::resource('books', 'BooksController');
    Route::resource('authors', 'AuthorsController');

    Route::get(
        'books/{book_id}/author', [
        'as' => 'api.books.author',
        'uses' => 'BooksController@getAuthorByBook'
    ]);

    Route::get(
        'authors/{author_id}/books', [
        'as' => 'api.authors.books',
        'uses' => 'AuthorsController@getBooksByAuthor'
    ]);
});