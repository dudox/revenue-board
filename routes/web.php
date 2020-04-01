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


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@commission')->name('commission');
    Route::get('/exports', 'HomeController@exports')->name('commission.exports');
    Route::get('/exports/make', 'HomeController@requestAllExport')->name('commission.exports.make');

});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('admin');
    Route::group(['prefix' => 'setings'], function () {
        Route::post('/', 'SettingsController@updateStartScreen')->name('settings.welcome.update');
    });
    Route::group(['prefix' => 'states'], function () {
        Route::get('/', 'StateController@index')->name('states');
        Route::get('/{state}', 'StateController@show')->name('states.show');
    });

    Route::group(['prefix' => 'exports'], function () {
        Route::get('/', 'ExportController@index')->name('exports');
        Route::get('/{state}', 'ExportAnalytics@export')->name('exports.state');
        Route::get('/{state}/{batch}', 'ExportAnalytics@export')->name('exports.batch');
    });

    Route::group(['prefix' => 'batches'], function () {
        Route::get('/{state}', 'BatchController@create')->name('batches.create');
        Route::post('/', 'BatchController@store')->name('batches.store');
        Route::get('/view/{batch}', 'BatchController@show')->name('batches.show');
        Route::get('/cards/{id}', 'CardController@viewDenominationCards')->name('cards.show');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'HomeController@users')->name('users');
        Route::get('/create', 'UserController@create')->name('users.create');
        Route::post('/store', 'UserController@store')->name('users.store');
        Route::post('/{user}', 'UserController@resetPassword')->name('users.password.reset');
        Route::post('/analytics/{state}', 'UserController@deleteAnalytics')->name('users.analytics.reset');
        Route::delete('/analytics', 'UserController@clearAllAnalytics')->name('users.data.reset');
        Route::get('/{user}', 'UserController@show')->name('users.show');
        Route::get('/activate/{user}', 'UserController@activate')->name('users.activate');
        Route::get('/ban/{user}', 'UserController@ban')->name('users.ban');
    });

    Route::group(['prefix' => 'denominations'], function () {
        Route::post('/', 'BatchController@storeDenominations')->name('denominations.store');
    });

    Route::group(['prefix' => 'entries'], function () {

    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect()->route('admin');
    });
});

Route::group(['prefix' => 'auth'], function () {
    Route::get('/logout', 'HomeController@logout')->name('auth.logout');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
