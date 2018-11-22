<?php

namespace Comisiones\Http\Controllers;

use Carbon\Carbon;
use Comisiones\Comision;
use Comisiones\Profesor;
use Comisiones\Instituto;
use Comisiones\Resolucion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Comisiones\Mail\SolicitudMail;
use Comisiones\Mail\AprobacionMail;
use Comisiones\Mail\DevolucionMail;
use Comisiones\Mail\VistoBuenoMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Comisiones\Jobs\GeneracionResolucion;
use Comisiones\Mail\AprobacionPermisoMail;
use Comisiones\Http\Controllers\ResolucionHilo;

class ComisionController extends Controller
{
   

    public function mostrarFormularioCrearComision(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do{
            $randstring = '';
            for ($i = 0; $i < 5; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
            }
            $comision = Comision::where('comisionid', $randstring)->get();
        }while(count($comision) > 0);
        return view('comision.crear')->with('random', $randstring)->with('fechaActual',Carbon::now());
    }

    public function crearComision(Request $request){
        $comision = new Comision();        
        $comision->comisionid = $request->comisionid;     
        //cedula
        $comision->cedula = Auth::user()->cedula;
        //institutoid
        $comision->institutoid = Auth::user()->institutoid;
        //fecha -> pendiente hacer datepicker
        $fecha = $request->fecharango;        

        if($request->justificacion){
            \Storage::disk('local')->put($request->comisionid . '/actividad.txt', $request->justificacion);
        }
        $comision->radicacion = $request->fecharadicacion;
        $comision->actualizacion = $request->fechaactualizacion;
        $comision->estado = 'solicitada';

        //procesado de fecha
        $calendario_meses = array(
            'January'=>'Enero',
            'Febuary'=>'Febrero',
            'March'=>'Marzo',
            'April'=>'Abril',
            'May'=>'Mayo',
            'June'=>'Junio',
            'July'=>'Julio',
            'August'=>'Agosto',
            'September'=>'Septiembre',
            'October'=>'Octubre',
            'November'=>'Noviembre',
            'December'=>'Diciembre'
        ); 
        
        $fecha = explode ('a', $fecha);
        // $comision->fechaini = date_format( date_create($fecha[0]), date('d-m-y')); 
        // $comision->fechafin = date_format( date_create($fecha[1]), date('d-m-y')); 
        
        // $comision->fecha = $calendario_meses[date_format(date_create($fecha[0]), 'F')]
        //                     . ' ' .date_format( date_create($fecha[0]), 'd \d\e o') 
        //                     . ' a ' . $calendario_meses[date_format(date_create($fecha[0]), 'F')]. ' ' . 
        //                     date_format( date_create($fecha[1]), 'd \d\e o'); 
        //fin procesado fecha

        //actividad
        $comision->actividad = $request->actividad;
        //lugar
        $comision->lugar = $request->lugar;
        //tipocom
        $comision->tipocom = $request->tipocom;
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

        $comision->vistobueno = 'No';
        $comision->aprobacion = 'No';         
        $comision->save();
        // $env = env('APP_DEBUG');
        // dd($env);
        if(env('APP_DEBUG', false)){
            //enviar correo de prueba
            Mail::to(env('EMAIL_PRUEBA'))->send(new SolicitudMail($comision));
        }else{
            //enviar correo al director del instituto y a la secretaria del instituto
            // Mail::to('bkunde384@hideweb.xyz')->send(new SolicitudMail($comision));
            dd($comision);
        }
        return redirect('/inicio');
    }

    public function ordenarComisiones(Request $request, $ordenapor){
        $url = explode('?', $request->fullUrl());
        $orden = Session::get('orden');
        $jefe = Session::get('jefe');
        if(!$orden){
            Session::put('orden', 'desc');
        }
        else if(empty($url[1])){
            if(strcmp($orden, 'desc') == 0){
                $orden = 'asc';
                Session::put('orden', 'asc');
            }
            else{
                $orden = 'desc';
                Session::put('orden', 'desc');
            }            
        }
        
        $usuario = Auth::user();            
        $instituto = Instituto::where('cedulajefe', $usuario->cedula)->orwhere('emailinst', $usuario->email)->first();     
        if($jefe == 1){            
            //Si el usuario es director recupera las comisiones del instituto            
            $comisiones = Comision::where('institutoid', $instituto->institutoid)
                                    ->orderby($ordenapor, $orden)
                                    ->paginate(15);
        }
        else if( $jefe == 2){
        //Si el usuario es decano recupera todas lascomisiones
        $comisiones = Comision::orderby($ordenapor,$orden)
                                ->paginate(15);
        }
        else{
            $comisiones = Comision::where('cedula', $usuario->cedula)
                                    ->orderby($ordenapor,$orden)
                                    ->paginate(15);
        }
        // dd($comisiones[0]->profesor->nombre);
       
        return view('admin.app')->with('comisiones', $comisiones);
        // return view('admin.app',compact('comisiones'));
    }
    
    public function mostrarComisiones(){
        $usuario = Auth::user();               
        $instituto = Instituto::where('cedulajefe', $usuario->cedula)->first();
        $jefe = \Session::get('jefe');
        $faltacumplido =null;
        if($jefe == 1){
            //Si el usuario es director recupera las comisiones del instituto            
            $comisiones = Comision::where('institutoid', $usuario->institutoid)
                                    ->orderby('radicacion','desc')
                                    ->paginate(15);                                                   
        }
        else if($jefe == 2){
            //Si el usuario es decano recupera todas lascomisiones        
            $comisiones = Comision::orderby('radicacion','desc')
                                    ->paginate(15);
        }
        else{
            $faltacumplido = Comision::whereRaw('(tipocom<>"noremunerada" and tipocom<>"calamidad") and cedula='.$usuario->cedula.' and fechafin<now() and qcumplido+0=0')
                                        ->get(array('comisionid'));                                        
                                        
//select comisionid from Comisiones where (tipocom<>'noremunerada' and tipocom<>'calamidad') and cedula='$cedula' and fechafin<now() and qcumplido+0=0;



            $comisiones = Comision::where('cedula', $usuario->cedula)
                                    ->orderby('radicacion','desc')
                                    ->paginate(15);
        }       
        return view('admin.app',compact(['comisiones', 'faltacumplido']));
    }

    public function mostrarFormularioActualizaComision($comisionid){
        $instituto = Instituto::where('cedulajefe', Auth::user()->cedula)->first();
        
        $comision = Comision::where('comisionid', $comisionid)
                            //   ->where('cedula', Auth::guard('profesor')->user()->cedula)
                              ->get();
        if(\Storage::disk('local')->exists($comisionid . '/actividad.txt')){
            $comision[0]->justificacion = \Storage::disk('local')->get($comisionid . '/actividad.txt');
        }
        if(\Storage::disk('local')->exists($comisionid . '/respuesta.txt')){
            $comision[0]->respuesta = \Storage::disk('local')->get($comisionid . '/respuesta.txt');
        }
        
        $comision[0]->fecha = date_format( date_create($comision[0]->fechaini), date('d F Y')). ' a '.
                                date_format( date_create($comision[0]->fechafin), 'd F Y'); 
        
        $objeto = date_create_from_format('Y-F-d', $comision[0]->fechaini);
        
        
        return view('comision.actualizar')
                ->with('comision', $comision)
                ->with('fechaActual',Carbon::now());
    }
 
    public function actualizarComision(Request $request, $id ){
       
        $comision = Comision::where('comisionid', $id)->first();
        $jefe = Session::get('jefe');
        $comision->actualiza = Auth::user()->cedula;
        $comision->actualizacion = $request->fechaactualizacion;

        //devolucion
        if($jefe > 0 && strcmp($request->devolucion, 'Si') == 0 && !\Storage::disk('local')->exists($comision->comisionid . '/respuesta.txt')){
            $comision->estado = 'devuelta';
            $comision->vistobueno = 'No';
            $comision->aprobacion = "No";
            \Storage::disk('local')->put($comision->comisionid . '/respuesta.txt', $request->respuesta);
            if(env('APP_DEBUG', false)){
                //enviar correo de prueba
                Mail::to(env('EMAIL_PRUEBA'))->send(new DevolucionMail($comision, $request->respuesta));
            }else{
                //enviar correo a profesor devolucion
                // Mail::to('bkunde384@hideweb.xyz')->send(new DevolucionMail($comision));
                dd($comision);
            }
        }
        else{ 
            if($jefe == 1){
                if($comision->vistobueno == 'No' && $request->vistobueno == 'Si'){
                    $comision->vistobueno = $request->vistobueno;    
                    $comision->estado = 'vistobueno'; 
                    //envio de correo a director y secretaria de director 
                    if(env('APP_DEBUG', false)){
                        //enviar correo de prueba
                        Mail::to(env('EMAIL_PRUEBA'))->send(new VistoBuenoMail($comision));
                    }else{
                        //enviar correo a director y a la secretaria de director
                        // Mail::to('bkunde384@hideweb.xyz')->send(new SolicitudMail($comision));
                        dd($comision);
                    }
                }
            }
            else if($jefe == 2){
                if($comision->aprobacion == 'No' && $request->aprobacion == 'Si'){                 
                    $comision->aprobacion = $request->aprobacion;   
                    $comision->estado = 'aprobada';
                    
                    $resolucion = new Resolucion();
                    $resolucion->comisionid = $comision->comisionid;
                    $resolucion->save();
                    $comision->resolucion = $resolucion->resolucionid;

                    
                    $calendario_meses = array(
                        'January'=>'Enero',
                        'Febuary'=>'Febrero',
                        'March'=>'Marzo',
                        'April'=>'Abril',
                        'May'=>'Mayo',
                        'June'=>'Junio',
                        'July'=>'Julio',
                        'August'=>'Agosto',
                        'September'=>'Septiembre',
                        'October'=>'Octubre',
                        'November'=>'Noviembre',
                        'December'=>'Diciembre'
                    ); 
                    $fecha = Carbon::now();
                    $fecha1 = $fecha->format('d \d\e ') . $calendario_meses[$fecha->format('F')] . $fecha->format(' \d\e Y');
                    $comision->fecharesolucion = $fecha1; 
                    
                    //generar resolucion y envio de correo a secretaria de decana y a profesor
                    if(!\Storage::disk('local')->exists($comision->comisionid)){
                        \Storage::makeDirectory($comision->comisionid);
                    }
                    if(strcmp($comision->tipocom, 'calamidad')==0 || strcmp($comision->tipocom, 'noremunerada')==0){

                        $pdfResolucion = PDF::loadView('emails.comisiones.resolucionPermiso', ['comision' => $comision, 'blank' => 1])
                                                ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-blank-'.$comision->comisionid.'.pdf');
                        
                        $pdfResolucion = PDF::loadView('emails.comisiones.resolucionPermiso', ['comision' => $comision, 'blank' => 0])
                                                ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-'.$comision->comisionid.'.pdf');
                   
                        //envio de correo a decana y secretaria de decana 
                        if(env('APP_DEBUG', false)){
                            //enviar correo de prueba
                            Mail::to(env('EMAIL_PRUEBA'))->send(new AprobacionPermisoMail($comision));
                        }else{
                            //enviar correo a decana y a la secretaria de decana
                            // Mail::to('bkunde384@hideweb.xyz')->send(new SolicitudMail($comision));
                            dd($comision);
                        }
                    }else{ 
                        
                        $pdfResolucion = PDF::loadView('emails.comisiones.resolucionPermiso', ['comision' => $comision, 'blank' => 1])
                                                ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-blank-'.$comision->comisionid.'.pdf');
                        
                        $pdfResolucion = PDF::loadView('emails.comisiones.resolucionPermiso', ['comision' => $comision, 'blank' => 0])
                                                ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-'.$comision->comisionid.'.pdf');
                    
                    
                        //envio de correo a decana y secretaria de decana 
                        if(env('APP_DEBUG', false)){
                            //enviar correo de prueba
                            Mail::to(env('EMAIL_PRUEBA'))->send(new AprobacionMail($comision));
                        }else{
                            //enviar correo a decana y a la secretaria de decana
                            // Mail::to('bkunde384@hideweb.xyz')->send(new SolicitudMail($comision));
                            dd($comision);
                        }
                    }

                   

                }           

            }
            else{
                $comision->tipocom = $request->tipoComision;
                $comision->lugar = $request->lugar;
                $comision->actividad = $request->actividad;
                $comision->idioma = $request->idioma;
                if($request->justificacion){
                    \Storage::disk('local')->put($request->comisionid . '/actividad.txt', $request->justificacion);
                }
            }
        }
                    

        
        
        $comision->save();
        return redirect('inicio');
    }

    public function eliminarComision($id){
        $comision = Comision::where('comisionid', $id)->first();
        $comision->delete();
        //eliminar carpeta de la comision
        \Storage::disk('local')->deleteDirectory($id);
        return redirect('/inicio');
    }
}

