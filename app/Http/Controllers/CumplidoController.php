<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Comision;
use Illuminate\Http\Request;

class CumplidoController extends Controller
{
    public function mostrarFormularioCumplido($id){
        $comision =  Comision::where('comisionid', $id)->first();
        return view('cumplido.cumplidoformulario', compact('comision'));
    }

    public function crearCumplido(Request $request){
        dd($request);


    }

}
