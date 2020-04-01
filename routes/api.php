<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'services'], function () {
    Route::post('/ussd', 'API\USSD\Process@index')->name('ussd.start');
});

Route::group(['prefix' => 'denominations'], function () {
    Route::get('/{batch}', 'BatchController@getDenominations')->name('denominations.get');
    Route::get('/ongoing/{batch}', 'CardController@ongoing')->name('denominations.ongoing');
    Route::get('/generate/{denomination}/{total}/{batch}', 'CardController@makeDenomination')->name('denominations.ongoing');
    Route::get('/export/{batch}', 'CardController@export')->name('denominations.export.all');
    Route::get('/sendout/{batch}', 'CardController@export')->name('denominations.send.all');
    Route::get('/export/{batch}/{denomination}', 'CardController@export')->name('denominations.export.one');
});
