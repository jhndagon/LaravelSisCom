<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Comision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InformeController extends Controller
{
    //
    public function mostrarFormularioInformes(){
        return view('informes.informe');
    }

    public function hacerBusqueda(Request $request){
        $opcion = $request->opciones;
        $busqueda = $request->busqueda;
        $sebusco = ['opcion'=>$opcion, 'busqueda'=>$busqueda];
        $comisiones = null;
        $esquema = Schema::getColumnListing('Comisiones');
        if($opcion == 'todas'){
            $comisiones = Comision::all();
        }
        else if($opcion == 'permisos'){

        }
        else if($opcion == 'cedula'){
            if($busqueda){
                $comisiones = Comision::where('cedula', 'like', $busqueda.'%')->paginate(20);
            }
            else {
                return back()->withErrors(['busqueda'=>'No se ha ingresado una número de cedula en el campo buscar.']);
            }
        }
        return view('informes.informe', compact(['comisiones', 'esquema', 'sebusco']));
    }
}
