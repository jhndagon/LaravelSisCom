<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Comision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComisionController extends Controller
{
    
    public function mostrarComisiones(){
        $user = Auth::user();       
        $comisiones = Comision::where('cedula', $user->cedula)->get();
        return view('admin.app',compact('comisiones'));
    }

    public function actualizarComision($comisionid){
        $comision = Comision::where('comisionid', $comisionid)
                              ->where('cedula', Auth::guard('profesor')->user()->cedula)
                              ->get();
        return view('admin.comision')->with('comision', $comision);
    }
    
}
