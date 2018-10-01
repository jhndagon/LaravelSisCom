<?php

namespace Comisiones\Http\Controllers\Auth;

use Comisiones\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Comisiones\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ProfesorController extends Controller
{
    //

    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:profesor');
    }
    
    protected function guard(){
        return Auth::guard('profesor');
    }
    
    public function username(){
        return 'cedula';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        $user = Profesor::where('cedula', $request->cedula)->first();

        if($user || $user->pass == md5($request->password)){
            $user->pass = bcrypt($request->password);
            $user->save();
            $user = Profesor::where('cedula', $request->cedula)->first();
        }

        if(Auth::guard('profesor')->attempt(['cedula' => $request->cedula, 'password' => $request->password])){
            return redirect('inicio');
        }
        return back()->withErrors(['cedula' => "El número de cedula o contraseña incorrecto"])
        ->withInput(request(['cedula']));

    }

    public function logout(){
        Auth::guard('profesor')->logout();
        return redirect('/');
    }


}
