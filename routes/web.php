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
    return view('home');
})->name('home');

Route::get('/dec', function () {
    return view('decrypt');
})->name('dec');

Route::post('/encrypt', 'Encrypt\EncryptController@index')->name('encrypt');
Route::post('/decrypt', 'Decrypt\DecryptController@index')->name('decrypt');
