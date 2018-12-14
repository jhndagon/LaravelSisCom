<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModificaInformacionController extends Controller
{
    public function mostrarFormularioModicacionContrasena(){
        return view('admin.modificarcontrasena');
    }
    
    public function modificarContraseña(Request $request){
        $datos = $request->validate([
            'contrasenanueva' => 'required | alpha_num',
            'repetircontrasena' => 'required | alpha_num | same:contrasenanueva',
        ]);
        try{
            $profesor = Profesor::where('cedula', Auth::guard('profesor')->user()->cedula)->first();
            if($profesor){
                $profesor->laravelpass = bcrypt($request->contrasenanueva);
                $profesor->pass = md5($request->password);
                $profesor->save();
                return redirect('/inicio')->with(['notificacion1'=>'Contraseña cambiada.']);
            }
        }catch(Exception $e){
            abort(500);
        }        
    }
}
