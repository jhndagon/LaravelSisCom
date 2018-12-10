<?php

namespace Comisiones\Http\Controllers;

use Comisiones\Profesor;
use Illuminate\Http\Request;
use Comisiones\Mail\RecuperarUsuarioMail;

class RecuperarUsuarioController extends Controller
{
    public function mostrarFormulario(){
        return view('recuperar.usuario');
    }

    public function recuperarUsuario(Request $request){
        $correo = explode('@', $request->correo);
        if($correo[1] == 'udea.edu.co'){
            $usuario = Profesor::where('email', $request->correo)->first();
            if($usuario && $request->correo == $usuario->email){               
                //envio de correo
                dd('Cambiar cedula', $request->correo);
                //\Mail::to($request->correo)->send(new RecuperarUsuarioMail($usuario->cedula));   
                return redirect('inicio');
            }
            
        }       
        return redirect()->back()->withInput()->withErrors(['correo' => 'Verifique la información ingresada.']);
        
    }
}
