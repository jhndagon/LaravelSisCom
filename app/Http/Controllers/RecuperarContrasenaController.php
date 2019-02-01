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
            if($usuario && strcmp($request->correo,$usuario->email) == 0){
                
                $usuario->laravelpass = bcrypt($usuario->cedula);
                $usuario->pass = md5($usuario->cedula);
                $usuario->save();
                //envio de correo
                // TODO: recuperacion de contraseña
                //dd('Envio de recuperacion de contraseña a:', $request->correo);
                \Mail::to($usuario->email)->send(new RecuperarContrasenaMail($usuario->cedula));
                return redirect('/login')->with(['correoenviado'=>'Hemos enviado un correo electrónico con su nueva contraseña.']);
            }
            
        }       
        return redirect()->back()->withInput()->withErrors(['correo' => 'Su correo no fue reconocido. Intente de nuevo.']);
    }
}
