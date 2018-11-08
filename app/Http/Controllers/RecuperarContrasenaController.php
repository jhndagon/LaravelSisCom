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
        if($correo[1] == 'udea.edu.co'){
            $usuario = Profesor::where('cedula', $request->cedula)->first();
            if($usuario && $request->correo == $usuario->email){
                
                $usuario->pass = bcrypt($usuario->cedula);
                $usuario->save();
                //envio de correo
                //\Mail::to($request->correo)->send(new RecuperarContrasenaMail($usuario->cedula));   
                dd('Cambiar contraseña');
                return redirect('inicio');
            }
            
        }       
        return redirect()->back()->withInput()->withErrors(['correo' => 'Verifique la información ingresada.']);
    }
}
