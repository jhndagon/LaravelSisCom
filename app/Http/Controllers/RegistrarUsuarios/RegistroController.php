<?php

namespace Comisiones\Http\Controllers\RegistrarUsuarios;

use Comisiones\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Comisiones\Http\Controllers\Controller;

class RegistroController extends Controller
{
    public function showRegisterForm(){
        return view('admin.registro');
    }

    public function registrar(Request $request){
        $usuario = new Usuario();
        $usuario->email = $request->email;
        $usuario->usuario = $request->usuario;
        $usuario->cedula = $request->cedula;
        $usuario->password = Hash::make($request->password);
        $usuario->save(); 
        return 'registrando usuario' . $usuario;
    }
}
