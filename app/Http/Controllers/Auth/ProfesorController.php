<?php

namespace Comisiones\Http\Controllers\Auth;

use Carbon\Carbon;
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
        if ($usuario && strcmp($usuario->pass, md5($request->password)) == 0 && !isset($usuario->laravelpass)) {
            $usuario->laravelpass = bcrypt($request->password);
            $usuario->save();
            $usuario = Profesor::where('cedula', $request->cedula)->first();
        }
        if($usuario && Hash::check($request->password, $usuario->laravelpass)){      
            Auth::guard('profesor')->login($usuario);
            $instituto = Instituto::where('cedulajefe', $usuario->cedula)->orwhere('emailinst', $usuario->email)->first();
            $jefe = 0;
            if($instituto && $instituto->institutoid != 'decanatura'){
                $jefe = 1; // identifica a director o secretaria de instituto
            }
            else if ($instituto || $usuario->cedula=='71755174'){
                $jefe = 2; //identifica la decana o secretretaria de dacanato
            }
            $request->session()->put('jefe', $jefe);
            
            $sem=floor((date('m')-1) / 6)+1;
            $sem.='';
            if (isset($usuario->extra3) || $usuario->extra3 != ''){
                $semestrePermiso = explode('-', $usuario->extra3);

                //Conocer el semestre actual

                if($sem != $semestrePermiso[1]){
                    $usuario->extra3 = date('Y') . '-' . $sem;
                    $usuario->extra1 = 3;
                }
            }
            else{
                $usuario->extra3 = date('Y') . '-' .$sem;
                $usuario->extra1 = 3;
            }
            $usuario->save();

            return redirect('/inicio')->with(['notificacion1'=>'Señor usuario le sugerimos que cambie su 
                                                <a href='.url('/profesor/'.$usuario->cedula).'>información personal</a> 
                                                y ponga un correo institucional y una 
                                                <a href='.url('/modificarcontrasena').'>contraseña</a> segura.']);
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
        $opcion = $request->opcion;
        $buscar = $request->buscar;
        if(\Session::get('jefe') > 1 && $request->buscar != null && $request->opcion != null){
            $profesores = Profesor::where($request->opcion, 'like' ,'%'. $buscar .'%')->get();
            return view('profesores.profesores', compact('profesores', 'opcion', 'buscar'));
        }
        else{
            return redirect('inicio');
        }
    }

    public function editarInformacionFormulario($id){
        $profesor = Profesor::where('cedula',$id)->first();
        $tipos = Profesor::distinct()->select('tipo')->get(); //tipos de contrato
        $institutos = Instituto::all();
        return view('profesores.editarinformacion', compact('profesor'))
                ->with('tipos',$tipos)
                ->with('institutos', $institutos);
    }

    public function editarInformacion(Request $request){           
        $accion = $request->actualiza;
        if($accion == 'actualizar'){
            $profesor = Profesor::where('cedula', $request->cedulaanterior)->first();
        }
        else{
            $profesor = new Profesor();
            $profesor->laravelpass = Hash::make($request->cedula);
            $profesor->permisos = 3;            
        }
        $profesor->tipoid = $request->tipoid;
        $profesor->cedula = $request->cedula;
        $profesor->nombre = strtoupper($request->nombre);
        $correo = explode('@', $request->email);
        if(strcmp($correo[1], 'udea.edu.co') != 0){
            return back()->withErrors(['email' => 'Recuerde que el correo debe ser institucional']);
        }
        $profesor->email = $request->email;

        if(\Session::get('jefe')==2){
            $profesor->tipo = $request->tipo;
            $profesor->institutoid = $request->instituto;
            $profesor->tipo = $request->tipo;
            $profesor->dedicacion = $request->dedicacion;
        }
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
