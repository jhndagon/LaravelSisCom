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
                //dd('Cambiar cedula', $request->correo);
                \Mail::to($usuario->email)->send(new RecuperarUsuarioMail($usuario->cedula));   
                return redirect('/login')->with(['correoenviado'=>'Hemos enviado un correo electrónico con su usuario.']);
            }
            
        }       
        return redirect()->back()->withInput()->withErrors(['correo' => 'La información provista no coincide con la que existe en el sistema. Intente de nuevo.']);
        
    }
}
