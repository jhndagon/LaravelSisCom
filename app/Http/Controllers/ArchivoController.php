<?php

namespace Comisiones\Http\Controllers;

use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    function obtenerArchivo($comisionid, $documento){
        $ruta = '/' . $comisionid . '/'. $documento;
        
        if(\Storage::disk('local')->exists($ruta)){
            // dd(storage_path('app/comisiones').$ruta);
            return response()->download(storage_path('app/comisiones').$ruta);
            //return \Storage::disk('local')->download($ruta);
        }
        abort(404);        
    }

    function obtenerArchivoCumplido($comisionid, $documento){
        $ruta = '/' . $comisionid . '/'. $documento;

        if(\Storage::disk('local')->exists($ruta)){
            return response()->download(storage_path('app/comisiones').$ruta);
        }
        abort(404);        
    }
}
