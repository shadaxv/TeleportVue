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

Route::get('teleport', 'TeleportController@index')->name('teleport-index');
Route::post('result', 'TeleportController@result')->name('result-index');
Route::get('result', 'TeleportController@result')->name('result-index');
Route::post('teleport', 'TeleportController@autocomplete')->name('teleport-index');