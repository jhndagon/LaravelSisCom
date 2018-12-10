<?php

namespace Comisiones\Http\Controllers;

use Carbon\Carbon;
use Comisiones\Comision;
use Illuminate\Http\Request;
use Comisiones\Mail\CumplidoMail;
use Illuminate\Support\Facades\Mail;

class CumplidoController extends Controller
{
    public function mostrarFormularioCumplido($id){
        $comision =  Comision::where('comisionid', $id)->first();
        return view('cumplido.cumplidoformulario', compact(['comision', '']));
    }

    public function crearCumplido(Request $request){        
        if(!$request->envio) {
            return back()->withErrors(['aceptar'=>'Recuerde que su solicitud no se actualizará al estado de cumplida hasta que no autorice el envio del correo de notificación'])->withInput();
        }
        $comision = Comision::where('comisionid', $request->comisionid)->first();
        //captura de archivos
        $subioarchivo = false;        
        
        if($request->cumplido1){
            $archivo = $request->file('cumplido1');
            $nombre = $archivo->getClientOriginalName();
            $tamaño = $archivo->getClientSize();
            if($tamaño <=0){
                return back()->withErrors(['archivo' => 'No se ha subido ningún archivo.'])->withInput();
            }
            do{
                $ruta = \Storage::disk('local')->put($request->comisionid . '/Cumplido1_' .$nombre,  \File::get($archivo));
            }while(!$ruta);
            $comision->cumplido1 = $nombre;   
            $subioarchivo = true;         
        }
        if($request->cumplido2){
            $archivo = $request->file('cumplido2');
            $nombre = $archivo->getClientOriginalName();
            $tamaño = $archivo->getClientSize();
            if($tamaño <=0){
                return back()->withErrors(['archivo' => 'No se ha subido ningún archivo.'])->withInput();
            }            
            do{
                $ruta = \Storage::disk('local')->put($request->comisionid . '/Cumplido2_' . $nombre, \File::get($archivo));
            }while(!$ruta);
            $comision->cumplido2 = $nombre;
            $subioarchivo = true;
        }

        if(!$subioarchivo){           
            return back()->withErrors(['archivo' => 'No se ha subido ningún archivo.'])->withInput();
        }
        
        $comision->estado = 'cumplida';
        $comision->qcumplido = 1;  
        $correosCumplido = array();      
        if($request->correos){
            foreach ($request->correos as $key => $value) {                
                $comision->destinoscumplido .= $value . ';';
                array_push($correosCumplido, $value);
            }
        }
        if($request->otrosdestinatarios){            
            $otros = explode(',', $request->otrosdestinatarios);            
            foreach ($otros as $value) {
                $request->destinoscumplido .= $value . ';';
                array_push($correosCumplido, $value);
            }
        }
        $comision->infocumplido = $request->infocumplido;
        $comision->qcumplido = 1;
        $comision->save();
        //envio de correo
        if(env('APP_DEBUG')){
            //a correo de prueba
            // dd($correos);
            // foreach ($correos as $key => $value) {
                
                //     Mail::to(env('EMAIL_PRUEBA'))->send(new CumplidoMail($comision, \Auth::user()->nombre, $value));
                // }
        }else{            
            $correos = explode(';', $comision->destinoscumplido);
            //dd('Descomentar linea 88 de CumplidoController', $correosCumplido);
            // TODO: Envio de correos cumplido
            // Mail::to($correosCumplido)->send(new CumplidoMail($comision, \Auth::user()->nombre, $value));
            foreach ($correos as $key => $value) {
                
                Mail::to($value)->send(new CumplidoMail($comision, \Auth::user()->nombre, $value));
            }
        
        }

        return redirect('/inicio');

    }

    /**
     * Muestra la informacion cuando una pesona confirma el recibido de una comisión cumplida.
     */
    public function confirmarCumplido($comisionid, $confirma){
        $comision = Comision::where('comisionid', $comisionid)->first();
        $correos = explode(';', $comision->destinoscumplido);
        foreach ($correos as $indice => $valor) {
            if(strcmp($valor, $confirma) == 0){
                $comision->confirmacumplido .= $confirma . '::' . Carbon::now() . ';';
                $comision->save();
                return view('cumplido.confirma')
                    ->with('confirma', $confirma)
                    ->with('comisionid', $comisionid)
                    ->with('nombre', $comision->profesor->nombre);
            }
        }
    }


    public function mostrarFormularioActualizaCumplido($id){
        $comision =  Comision::where('comisionid', $id)->first();
        $cumplido = explode(';', $comision->confirmacumplido);
        $elementos = count($cumplido);
        $confirmacumplido = array();
        for ($i=0; $i < $elementos-1; $i++) { 
            $cumple = explode('::', $cumplido[$i]);
            $confirmacumplido[$cumple[0]] = $cumple[1];
        }
        // $confirmacumplido = json_encode($confirmacumplido);
        // dd($confirmacumplido);
        return view('cumplido.actualiza', compact(['comision', 'confirmacumplido']));
    }

}
