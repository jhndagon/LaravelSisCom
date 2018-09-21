<?php

namespace Comisiones\Http\Controllers\Auth;

use Comisiones\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Comisiones\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){

        $validator = $this->validate(request(), [
            'cedula' => 'required',
            'password' => 'required'
        ]);

        $userData = \Comisiones\Profesor::where('cedula',request('cedula'))->first();
        if ($userData && (password_verify(request('password'),$userData->pass) || md5($request->password) == $userData->pass ))
        {
            auth()->loginUsingId($userData->cedula);
            //log que necesites
            return view('admin.app');
        }
      //si estás aquí algo ha salido mal, 404, 401, 403??
      //  return redirect('/');

        
        return back()->withErrors(['cedula' => "El número de cedula o contraseña incorrecto"])
        ->withInput(request(['cedula']));

        // $credenciales = $this->validate(request(), [
        //     'email' => 'email|required|string',
        //     'password'=> 'required|string'
        // ]);

        // if(Auth::attempt($credenciales)){
        //     return redirect('/');
        // }

        // return back()->withErrors(['email' => trans('auth.failed')])
        // ->withInput(request(['email']));

        // $usuario = Usuario::all();
        // if($usuario){
        //     return view('admin.prueba', ['usuario'=>$usuario]);
        // }
        // return view('auth.login');
    }

    public function logout(Request $request){
        Auth::logout();
        return 'cerró sesión';
    }

}
