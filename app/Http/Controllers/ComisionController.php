<?php

namespace Comisiones\Http\Controllers;

use Carbon\Carbon;
use Comisiones\Comision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComisionController extends Controller
{

    public function crearComision(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do{
            $randstring = '';
            for ($i = 0; $i < 5; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
            }
            $randstring;
            $comision = Comision::where('comisionid', $randstring)->get();
        }while(!$comision);
        $fecha = Carbon::now();
        // $fecha->format('yyyy-MM-dd hh:mm:ss');
        return view('comision.crear')->with('random', $randstring)->with('fechaActual',$fecha);
    }
    
    public function mostrarComisiones(){
        $user = Auth::user();       
        $comisiones = Comision::where('cedula', $user->cedula)->get();
        return view('admin.app',compact('comisiones'));
    }

    public function actualizarComision($comisionid){
        $comision = Comision::where('comisionid', $comisionid)
                              ->where('cedula', Auth::guard('profesor')->user()->cedula)
                              ->get();
        return view('comision.comision')->with('comision', $comision);
    }
    
}
