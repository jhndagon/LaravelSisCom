<?php

namespace Comisiones\Http\Controllers;

use Carbon\Carbon;
use Comisiones\Comision;
use Comisiones\Profesor;
use Comisiones\Instituto;
use Illuminate\Http\Request;
use Comisiones\Mail\SolicitudMail;
use Illuminate\Support\Facades\Auth;

class ComisionController extends Controller
{

    public function mostrarFormularioCrearComision(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do{
            $randstring = '';
            for ($i = 0; $i < 5; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
            }
            $randstring;
            $comision = Comision::where('comisionid', $randstring)->get();
        }while(!$comision);
        return view('comision.crear')->with('random', $randstring)->with('fechaActual',Carbon::now());
    }

    public function crearComision(Request $request){
        $comision = new Comision();
        $comision->comisionid = $request->comisionid;
        //resolucion -> pendiente
        //fecharesolicion
        $comision->fecharesolucion = $request->fecharesolucion;        
        //cedula
        $comision->cedula = Auth::user()->cedula;
        //institutoid
        $comision->institutoid = Auth::user()->institutoid;
        //fecha -> pendiente hacer datepicker

        //actividad
        $comision->actividad = $request->actividad;
        //lugar
        $comision->lugar = $request->lugar;
        //tipocom
        $comision->tipocom = $request->tipocom;
        //objeto
        //idioma
        $comision->idioma = $request->idioma;

        //capturar archivos y guardar
        if($request->anexo1){
            $archivo = $request->file('anexo1');
            $nombre = $archivo->getClientOriginalName();
            do{
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' .$nombre,  \File::get($archivo));
            }while(!$ruta);
            $comision->anexo1 = $nombre;
            
        }
        if($request->anexo2){
            $archivo = $request->file('anexo2');
            $nombre = $archivo->getClientOriginalName();
            do{
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' . $nombre, \File::get($archivo));
            }while(!$ruta);
            $comision->anexo2 = $nombre;
        }
        if($request->anexo3){
            $archivo = $request->file('anexo3');
            $nombre = $archivo->getClientOriginalName();
            do{
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' . $nombre, \File::get($archivo));
            }while(!$ruta);
            $comision->anexo3 = $nombre;
        }

        //enviar correo al director del instituto y a la secretaria del instituto
        

        $comision->save();

        \Mail::to('gustaderdu@ezehe.com')->send(new SolicitudMail($comision));
    }
    
    public function mostrarComisiones(){
        $usuario = Auth::user();               
        $instituto = Instituto::where('cedulajefe', $usuario->cedula)->first();
        if($instituto){
            //Si el usuario es director recupera las comisiones del instituto
            if(strcmp($instituto->institutoid, 'decanatura')!=0){//$instituto->instituoid != 'decanatura'){
                $comisiones = Comision::where('institutoid', $instituto->institutoid)->get();
            }
            //Si el usuario es decano recupera todas lascomisiones
            else{
                $comisiones = Comision::all();
            }
        }
        else{
            $comisiones = Comision::where('cedula', $usuario->cedula)->get();
        }
        // dd($comisiones[0]->profesor->nombre);
        return view('admin.app',compact('comisiones'));
    }

    public function mostrarFormularioActualizaComision($comisionid){
        $instituto = Instituto::where('cedulajefe', Auth::user()->cedula)->first();
        $jefe = 0;
        if($instituto && $instituto->institutoid != 'decanatura'){
            $jefe = 1; //representa director de instituto
        }
        else if($instituto){
            $jefe = 2; //representa decanatura
        }
        $comision = Comision::where('comisionid', $comisionid)
                            //   ->where('cedula', Auth::guard('profesor')->user()->cedula)
                              ->get();
        return view('comision.comision')
                ->with('comision', $comision)
                ->with('fechaActual',Carbon::now())
                ->witH('jefe', $jefe);
    }
 
    public function actualizarComision($id, Request $request){
        $comision = Comision::where('comisionid', $id)->first();
        $instituto = Instituto::where('cedulajefe', Auth::user()->cedula)->first();
        $jefe = 0;
        if($instituto && $instituto->institutoid != 'decanatura'){
            $comision->vistobueno = $request->vistobueno;
            $jefe = 1; //representa director de instituto
        }
        else if($instituto){
            $jefe = 2; //representa decanatura
        }
        dd($request);
    }

    public function eliminarComision($id){
        $comision = Comision::where('comisionid', $id)->first();
        $comision->delete();
    }
}

