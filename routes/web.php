<?php

////  /comisiones

//inicio de sesion
Route::get('/login', 'Auth\ProfesorController@showLoginForm')->name('login');
Route::post('/login', 'Auth\ProfesorController@login');

//cerrar sesion
Route::get('/logout', 'Auth\ProfesorController@logout')->name('logout');

//recuperacion de contraseña
Route::get('/recuperacontrasena', 'RecuperarContrasenaController@mostrarFormulario')->name('recuperacontrasena');
Route::post('/recuperacontrasena', 'RecuperarContrasenaController@recuperarContrasena');

//recuperacion de usuario
Route::get('/recuperausuario', 'RecuperarUsuarioController@mostrarFormulario')->name('recuperausuario');
Route::post('/recuperausuario', 'RecuperarUsuarioController@recuperarUsuario');

// comisiones con autenticacion
Route::group(['middleware' => 'auth:profesor'], function () {    
    Route::get('/', function () {
        return redirect('inicio');
    });
    
    Route::get('/inicio','ComisionController@mostrarComisiones')->name('inicio');
    Route::get('/inicio/{ordenapor}','ComisionController@ordenarComisiones');
    Route::get('/comision', 'ComisionController@mostrarFormularioCrearComision')->name('comision');
    Route::post('/comision', 'ComisionController@crearComision');
    Route::get('/comision/{comision}','ComisionController@mostrarFormularioActualizaComision')->name('comision');
    Route::get('/eliminarComision/{id}', 'ComisionController@eliminarComision');
    Route::put('/comision/{comision}', 'ComisionController@actualizarComision');
    
    Route::get('/archivo/{comisionid}/{documento}', 'ArchivoController@obtenerArchivoAnexo');


    Route::get('/modificarcontrasena', 'ModificaInformacionController@mostrarFormularioModicacionContrasena')->name('modificarcontrasena');
    Route::post('/modificarcontrasena', 'ModificaInformacionController@modificarContraseña');

    Route::get('/profesores', 'Auth\ProfesorController@listar')->name('profesores');
    Route::get('/profesor', 'Auth\ProfesorController@buscar');
    Route::get('/profesor/{id}', 'Auth\ProfesorController@editarInformacionFormulario');
    Route::post('/profesor/{id}', 'Auth\ProfesorController@editarInformacion');
    Route::get('/eliminaprofesor/{id}', 'Auth\ProfesorController@eliminarProfesor');
});
