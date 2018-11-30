<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Comision;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    //
    public function mostrarFormularioInformes(){
        return view('informes.informe');
    }

    public function hacerBusqueda(Request $request){
        $opcion = $request->opciones;
        $busqueda = $request->busqueda;

        if($opcion == 'todas'){

        }
        else if($opcion == 'permisos'){

        }
        else if($opcion == 'cedula'){
            if($busqueda){
                $comisiones = Comision::where('cedula', 'like', $busqueda.'%')->get();
                return view('informes.informe', compact('comisiones'));
            }
            else {
                return back()->withErrors(['busqueda'=>'No se ha ingresado una número de cedula en el campo buscar.']);
            }
        }
    }
}
