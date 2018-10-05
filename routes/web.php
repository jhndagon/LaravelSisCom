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


Route::get('login', 'Auth\ProfesorController@showLoginForm')->name('login');
Route::post('login', 'Auth\ProfesorController@login');
Route::get('logout', 'Auth\ProfesorController@logout')->name('logout');

Route::group(['middleware' => 'auth:profesor'], function () {
    
    Route::get('/', function () {
        return redirect('inicio');
    });
    
    Route::get('inicio','ComisionController@mostrarComisiones')->name('inicio');
    Route::get('comision', 'ComisionController@crearComision')->name('comision');
    Route::get('comision/{comision}','ComisionController@actualizarComision')->name('comision');
});