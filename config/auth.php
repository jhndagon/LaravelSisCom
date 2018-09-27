<?php

return [

  //
'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
],
'profesor' => [
    'guard'=> 'profesor',

],
//
//
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'token',
        'provider' => 'users',
    ],
    'profesor' => [
        'driver' => 'session',
        'provider' => 'profesores',
    ],
    'profesor-api' => [
        'driver' => 'token',
        'provider' => 'profesores',
    ],
],
//
//
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => Comisiones\User::class,
    ],
   'profesores' => [
        'driver' => 'eloquent',
        'model' => Comisiones\Profesor::class,
    ],
],
//
//
'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
    ],
],


];
