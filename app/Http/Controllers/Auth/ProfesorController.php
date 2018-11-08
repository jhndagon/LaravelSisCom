<?php

namespace Comisiones\Http\Controllers\Auth;

use Comisiones\Profesor;
use Comisiones\Instituto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Comisiones\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ProfesorController extends Controller
{
    //

    use AuthenticatesUsers;

    protected $redirectTo = '/inicio';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:profesor');
    }

    protected function guard()
    {
        return Auth::guard('profesor');
    }

    public function username()
    {
        return 'cedula';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if ($this->guard()->check()) {
            return redirect('inicio');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {        
        $user = Profesor::where('cedula', $request->cedula)->first();
        if ($user && strcmp($user->pass, md5($request->password)) == 0 ) {
            $user->pass = bcrypt($request->password);
            $user->save();
            $user = Profesor::where('cedula', $request->cedula)->first();
        }
        if($user && Hash::check($request->password, $user->pass)){            
            Auth::guard('profesor')->login($user);
            $instituto = Instituto::where('cedulajefe', $user->cedula)->first();
            $jefe = 0;
            if($instituto && $instituto->institutoid != 'decanatura'){
                $jefe = 1; // identifica a director de instituto
            }
            else if ($instituto){
                $jefe = 2; //identifica la decana
            }
            else{
                $instituto = Instituto::where('emailinst', $user->email)->first();
                if($instituto && strcmp($instituto->emailinst, 'luz.castro@udea.edu.co') == 0) {
                    $jefe = 2; //identifica secretaría decana
                }
            }
            $request->session()->put('jefe', $jefe);
            return redirect('inicio');
        }
        return back()->withErrors(['cedula' => "El número de cedula o contraseña incorrecto"])
            ->withInput(request(['cedula']));

    }

    public function profesores(){
        if(\Session::get('jefe') > 0){
            $profesores = Profesor::all();
            return view('profesores.profesores')->with('profesores', $profesores);
        }
        else{
            return redirect('inicio');
        }
    }

    public function logout()
    {
        Auth::guard('profesor')->logout();
        \Session::flush();
        return redirect('/');
    }

}
