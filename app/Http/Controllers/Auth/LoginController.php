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
      
        return back()->withErrors(['cedula' => "El número de cedula o contraseña incorrecto"])
        ->withInput(request(['cedula']));
    }

    public function logout(Request $request){
        Auth::logout();
        return 'cerró sesión';
    }

}
