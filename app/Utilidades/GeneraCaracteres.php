<?php

namespace Comisiones\Utilidades;

class GeneraCaracteres {
    public static function generarRandomCaracteres($cantidad){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';        
        $randstring = '';
        for ($i = 0; $i < $cantidad; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }
}