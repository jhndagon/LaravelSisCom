<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Comision;
use Comisiones\Profesor;
use Comisiones\Instituto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Comisiones\Exports\ComisionesExport;

class InformeController extends Controller
{
    //
    public function mostrarFormularioInformes(){
        $institutos = Instituto::all();
        $tipocom = Comision::distinct()->select('tipocom')->get();
        return view('informes.informe', compact(['institutos', 'tipocom']));
    }

    public function hacerBusqueda(Request $request){
        $opcion = $request->opciones;
        $busqueda = $request->busqueda;
        $sebusco = ['opcion'=>$opcion, 
                    'busqueda'=>$busqueda, 
                    'fecha'=>$request->fecharango, 
                    'tipocom'=>$request->tipocom, 
                    'institutos'=>$request->institutos];

        $comisiones = null;
        $esquema = Schema::getColumnListing('Comisiones');
                if($opcion == 'todas'){
            $comisiones = Comision::where('cedula','like','%');
        }
        else if($opcion == 'permisos'){
            $comisiones = Comision::orWhere('tipocom', 'noremunerada')->orWhere('tipocom','calamidad');
        }
        else if($opcion == 'cedula'){
            if($busqueda){
                $comisiones = Comision::where('cedula', 'like', $busqueda.'%');
            }
            else {
                return back()->withErrors(['busqueda'=>'No se ha ingresado un número de cedula en el campo buscar.']);
            }
        }
        else if($opcion == 'fecha'){
            $fechas = explode(' a ', $request->fecharango);
            $comisiones = Comision::where('fechaini', '>=' , $fechas[0])
                                  ->Where('fechafin','<=', $fechas[1]);
            
        }
        $comisiones->where(function($q) use ($request){
            if($request->institutos==null){
                $q->orwhere('cedula', 'like','%');
            }else{

                foreach($request->institutos as $instituto){
                    $q->orWhere('institutoid', $instituto);
                }
            }
        });
        $comisiones->where(function($q) use ($request){
            if($request->tipocom==null){
                $q->orwhere('cedula', 'like','%');
            }else{
                foreach($request->tipocom as $tipo){
                    $q->orWhere('tipocom', $tipo);
                }
            }
        });
        $comisiones = $comisiones->get();
        $institutos = Instituto::all();
        $tipocom = Comision::distinct()->select('tipocom')->get();
        return view('informes.informe', compact(['comisiones', 'esquema', 'sebusco','institutos','tipocom']));
    }

    public function generarInformeExcel($info){        
        return Excel::download(new ComisionesExport($info), 'comisiones.xlsx');
    }
}
