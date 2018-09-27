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
    return redirect('/login');
});


Route::get('login', 'Auth\ProfesorController@showLoginForm')->name('login');
Route::post('login', 'Auth\ProfesorController@login');
Route::get('logout', 'Auth\ProfesorController@logout')->name('logout');

Route::get('inicio','ComisionController@mostrarInformacion')->name('inicio')->middleware('auth:profesor');