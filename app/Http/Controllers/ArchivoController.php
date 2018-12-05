<?php

namespace Comisiones\Http\Controllers;

use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    function obtenerArchivo($comisionid, $documento){
        $ruta = '/' . $comisionid . '/'. $documento;

        if(\Storage::disk('local')->exists($ruta)){
            return \Storage::disk('local')->download($ruta);
        }
        abort(404);        
    }

    function obtenerArchivoCumplido($comisionid, $documento){
        $ruta = '/' . $comisionid . '/'. $documento;

        if(\Storage::disk('local')->exists($ruta)){
            return \Storage::disk('local')->download($ruta);
        }
        abort(404);        
    }
}
