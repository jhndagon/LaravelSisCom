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
    use AuthenticatesUsers;

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
    public function mostrarFormularioLogin()
    {
        if ($this->guard()->check()) {
            return redirect('inicio');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {        
        $usuario = Profesor::where('cedula', $request->cedula)->first();
        if ($usuario && strcmp($usuario->pass, md5($request->password)) == 0 ) {
            $usuario->pass = bcrypt($request->password);
            $usuario->save();
            $usuario = Profesor::where('cedula', $request->cedula)->first();
        }
        if($usuario && Hash::check($request->password, $usuario->pass)){      
            Auth::guard('profesor')->login($usuario);
            $instituto = Instituto::where('cedulajefe', $usuario->cedula)->orwhere('emailinst', $usuario->email)->first();
            $jefe = 0;
            if($instituto && $instituto->institutoid != 'decanatura'){
                $jefe = 1; // identifica a director o secretaria de instituto
            }
            else if ($instituto){
                $jefe = 2; //identifica la decana o secretretaria de dacanato
            }
            // else{
            //     // $instituto = Instituto::where('emailinst', $usuario->email)->first();
            //     if($instituto && strcmp($instituto->emailinst, 'luz.castro@udea.edu.co') == 0) {
            //         $jefe = 2; //identifica secretaría decanato, tiene los mismos permisos que la decana
            //     }
            // }
            $request->session()->put('jefe', $jefe);
            return redirect('inicio');
        }
        return back()->withErrors(['cedula' => "El número de la cédula o contraseña incorrecto."])
            ->withInput(request(['cedula']));

    }

    public function listar(){
        if(\Session::get('jefe') > 1){
            $profesores = Profesor::all();
            return view('profesores.profesores', compact('profesores'));
        }
        else{
            return redirect('inicio');
        }
    }

    public function buscar(Request $request){
        if(\Session::get('jefe') > 1 && $request->buscar != null && $request->opcion != null){
            $profesores = Profesor::where($request->opcion, 'like' ,'%'. $request->buscar.'%')->get();
            return view('profesores.profesores', compact('profesores'));
        }
        else{
            return redirect('inicio');
        }
    }

    public function editarInformacionFormulario($id){
        $profesor = Profesor::where('cedula',$id)->first();
        $tipos = Profesor::distinct()->select('tipo')->get(); //tipos de contrato
        $institutos = Instituto::distinct()->select('institutoid')->get();
        return view('profesores.editarinformacion', compact('profesor'))
                ->with('tipos',$tipos)
                ->with('institutos', $institutos);
    }

    public function editarInformacion(Request $request){            
        $profesor = Profesor::where('cedula', $request->cedula)->first();                
        $profesor->tipoid = $request->tipoid;
        $profesor->cedula = $request->cedula;
        $profesor->nombre = strtoupper($request->nombre);
        $correo = explode('@', $request->email);
        if(strcmp($correo[1], 'udea.edu.co') != 0){
            return back()->withErrors(['email' => 'Recuerde que el correo debe ser institucional']);
        }
        $profesor->email = $request->email;
        $profesor->tipo = $request->tipo;
        $profesor->institutoid = $request->instituto;
        $profesor->tipoid = $request->tipoid;
        $profesor->tipoid = $request->tipoid;
        $profesor->save();
        return redirect('/profesores');
    }

    public function eliminarProfesor($id){
        $profesor = Profesor::where('cedula', $id)->first();
        $profesor->delete();
        return redirect('/profesores');
    }

    public function logout()
    {
        Auth::guard('profesor')->logout();
        \Session::flush();
        return redirect('/');
    }

}
