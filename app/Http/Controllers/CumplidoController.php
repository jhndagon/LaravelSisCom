<?php

namespace Comisiones\Http\Controllers;

use Carbon\Carbon;
use Comisiones\Comision;
use Illuminate\Http\Request;
use Comisiones\Mail\CumplidoMail;
use Illuminate\Support\Facades\Mail;
use Comisiones\Utilidades\GeneraCaracteres;

class CumplidoController extends Controller
{
    public $correosprueba = array('jhndagon11@gmail.com','jhndagon12@gmail.com');
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
        $notificacion1 = '';
        $notificacion2 = '';       
        
        if($request->cumplido1){
            $archivo = $request->file('cumplido1');
            $extension = $archivo->getClientOriginalExtension();
            $tamaño = $archivo->getClientSize();
            if($tamaño <=0){
                return back()->withErrors(['archivo' => 'No se ha subido ningún archivo.'])->withInput();
            }
            $randstring = GeneraCaracteres::generarRandomCaracteres(5);
            do{
                $ruta = \Storage::disk('local')->put($request->comisionid . '/Cumplido1_' . $comision->cedula .'_'. $comision->comisionid .'_'.$randstring .'.'.$extension,  \File::get($archivo));
            }while(!$ruta);
            $comision->cumplido1 = $randstring .'.'.$extension;
            $notificacion1 = 'Archivo de Cumplido '. $comision->cumplido1.' subido';   
            $subioarchivo = true;         
        }
        if($request->cumplido2){
            $archivo = $request->file('cumplido2');
            $extension = $archivo->getClientOriginalExtension();
            $tamaño = $archivo->getClientSize();
            if($tamaño <=0){
                return back()->withErrors(['archivo' => 'No se ha subido ningún archivo.'])->withInput();
            }
            $randstring = GeneraCaracteres::generarRandomCaracteres(5);
            do{
                $ruta = \Storage::disk('local')->put($request->comisionid . '/Cumplido2_' . $randstring .'.'.$extension, \File::get($archivo));
            }while(!$ruta);
            $comision->cumplido2 = $randstring .'.'.$extension;
            $notificacion1 .= '. <br/>Archivo de cumplido '. $comision->cumplido2.' subido.';
            $subioarchivo = true;
        }
        $notificacion1 .= '<br/><strong class="text-danger">Felicidades. Su comisioón se ha cumplodp con exito.</strong>';
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
        //%%%%%%%%%%%%%%%%%%%%%%%%%
        // TODO: enviar correo de cumplido
        //%%%%%%%%%%%%%%%%%%%%%%%%%            
        $correos = explode(';', $comision->destinoscumplido);
                        
        // foreach ($this->correosprueba as $value) {  
        //     $notificacion2 .= '<br/>Mensaje enviado a '.$value.'.';              
        //     Mail::to($value)->send(new CumplidoMail($comision, \Auth::user()->nombre, $value));
        // }

        for ($i=0; $i < count($correos)-1; $i++) { 
            $notificacion2 .= '<br/>Mensaje enviado a '.$correos[$i].'.';
            Mail::to($correos[$i])->send(new CumplidoMail($comision, \Auth::user()->nombre, $correos[$i]));            
        }
        
        return redirect('/inicio')->with(['notificacion1'=>$notificacion1, 'notificacion2'=>$notificacion2]);
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
