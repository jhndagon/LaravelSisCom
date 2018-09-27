<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Comision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComisionController extends Controller
{
    
    public function mostrarInformacion(){
        $user = Auth::user();       
        $comisiones = Comision::where('cedula', $user->cedula)->get();
        return view('admin.app',compact('comisiones'));
    }

}
