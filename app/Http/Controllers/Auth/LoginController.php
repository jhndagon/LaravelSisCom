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

    //     $validator = $this->validate(request(), [
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     $userData = \Comisiones\Usuario::where('email',request('email'))->first();
    //     if ($userData && \Hash::check(request('password'), $userData->password))
    //     {
    //         auth()->loginUsingId($userData->id);
    //         //log que necesites
    //     }
    //   //si estás aquí algo ha salido mal, 404, 401, 403??
    //     return redirect('/');

        $credenciales = $this->validate(request(), [
            'email' => 'email|required|string',
            'password'=> 'required|string'
        ]);

        if(Auth::attempt($credenciales)){
            return redirect('/');
        }

        return back()->withErrors(['email' => trans('auth.failed')])
        ->withInput(request(['email']));

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
