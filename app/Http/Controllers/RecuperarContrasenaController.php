<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Profesor;
use Illuminate\Http\Request;
use Comisiones\Mail\RecuperarContrasenaMail;

class RecuperarContrasenaController extends Controller
{
    public function mostrarFormulario(){
        
        return view('recuperar.contrasena');
    }

    public function recuperarContrasena(Request $request){
        $correo = explode('@', $request->correo);
        if(strcmp($correo[1], 'udea.edu.co') == 0){
            $usuario = Profesor::where('cedula', $request->cedula)->first();
            if($usuario && strcpm($request->correo, $usuario->email) == 0){
                
                $usuario->pass = bcrypt($usuario->cedula);
                $usuario->save();
                //envio de correo
                //\Mail::to($request->correo)->send(new RecuperarContrasenaMail($usuario->cedula));
                return redirect('inicio');
            }
            
        }       
        return redirect()->back()->withInput()->withErrors(['correo' => 'Verifique la información ingresada.']);
    }
}
