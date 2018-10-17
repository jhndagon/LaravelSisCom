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
////  /comisiones

Route::get('login', 'Auth\ProfesorController@showLoginForm')->name('login');
Route::post('login', 'Auth\ProfesorController@login');
Route::get('logout', 'Auth\ProfesorController@logout')->name('logout');

Route::group(['middleware' => 'auth:profesor'], function () {
    
    Route::get('/', function () {
        return redirect('inicio');
    });
    
    Route::get('inicio','ComisionController@mostrarComisiones')->name('inicio');
    Route::get('inicio/{ordenapor}','ComisionController@ordenarComisiones');
    Route::get('comision', 'ComisionController@mostrarFormularioCrearComision')->name('comision');
    Route::post('comision', 'ComisionController@crearComision');
    Route::get('comision/{comision}','ComisionController@mostrarFormularioActualizaComision')->name('comision');
    Route::get('/eliminarComision/{id}', 'ComisionController@eliminarComision');
    Route::put('comision/{comision}', 'ComisionController@actualizarComision');
    Route::get('archivo/{comisionid}/{documento}', 'ArchivoController@obtenerArchivo');
});

Route::get('/archivo', function(){
    dd(Storage::disk('local'));
});