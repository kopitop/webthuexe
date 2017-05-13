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

Route::group(['domain' => 'enigmatic-escarpment-34531.herokuapp.com'], function() {
    Auth::routes();
    Route::get('/', function () {
        return redirect('/home');
    });

    Route::get('/danh-muc', 'CategoryController@index');
    Route::get('/danh-muc/{slug}', 'CategoryController@show')->name('danh-muc');
    Route::get('/xe', 'CarController@index');
    Route::post('/xe/{slug}', 'CarController@order');
    Route::get('/xe/{slug}', 'CarController@show');

    Route::get('/ca-nhan', 'AccountController@index');
    Route::delete('/ca-nhan/{id}', 'AccountController@destroy');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'quan-tri', 'namespace' => 'Admin'], function() {
        Auth::routes();
        Route::group(['middleware' => ['auth', 'check_role']], function () {
            Route::get('/', 'HomeController@index');

            Route::resource('/users', 'UserController');
            Route::resource('/categories', 'CategoryController');
            Route::resource('/cars', 'CarController');
            Route::resource('/orders', 'OrderController');
        });
    });
});
