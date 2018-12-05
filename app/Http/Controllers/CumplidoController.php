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
        return view('cumplido.cumplidoformulario', compact('comision'));
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
        if($request->correos){
            foreach ($request->correos as $key => $value) {                
                $comision->destinoscumplido .= $value . ';';
            }
        }
        if($request->otrosdestinatarios){            
            $otros = explode(',', $request->otrosdestinatarios);            
            foreach ($otros as $value) {
                $request->destinoscumplido .= $value . ';';
            }
        }
        $comision->infocumplido = $request->infocumplido;
        $comision->save();

        //envio de correo
        if(env('APP_DEBUG')){
            //a correo de prueba
            $correos = explode(';', $comision->destinoscumplido);
            // dd($correos);
            foreach ($correos as $key => $value) {
                
                Mail::to(env('EMAIL_PRUEBA'))->send(new CumplidoMail($comision, \Auth::user()->nombre, $value));
            }
        }else{
            

        }


    }

    public function confirmarCumplido($comisionid, $confirma){
        $comision = Comision::where('comisionid', $comisionid)->first();
        $correos = explode(';', $comision->destinoscumplido);
        foreach ($correos as $indice => $valor) {
            if(strcmp($valor, $confirma) == 0){
                $comision->confirmacumplido .= $confirma . ' ' . Carbon::now() . ';';
                $comision->save();
                return view('cumplido.confirma')
                    ->with('confirma', $confirma)
                    ->with('comisionid', $comisionid)
                    ->with('nombre', $comision->profesor->nombre);
            }
        }
    }

}
