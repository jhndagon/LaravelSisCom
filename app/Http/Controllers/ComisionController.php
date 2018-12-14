<?php

namespace Comisiones\Http\Controllers;

use DateTime;
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
use Comisiones\Mail\AprobacionPermisoMail;
use Comisiones\Mail\AprobacionDirectorMail;
use Comisiones\Mail\DevolucionDirectorMail;
use Comisiones\Utilidades\GeneraCaracteres;
use Comisiones\Mail\NotificacionActualizacionProfesorMail;



class ComisionController extends Controller
{

    public $correosprueba = array('jhndagon11@gmail.com','jhndagon12@gmail.com');

    public function mostrarComisiones()
    {
        $usuario = Auth::user();
        $jefe = \Session::get('jefe');
        $faltacumplido = null;
        if ($jefe == 1) {
            //Si el usuario es director recupera las comisiones del instituto
            $comisiones = Comision::where('institutoid', $usuario->institutoid)
                ->orderby('radicacion', 'desc');
        } else if ($jefe == 2) {
            //Si el usuario es decano recupera todas las comisiones
            $comisiones = Comision::orderby('radicacion', 'desc');
        } else {
            $faltacumplido = Comision::whereRaw('(tipocom<>"noremunerada" and tipocom<>"calamidad") and cedula=' . $usuario->cedula . ' and fechafin<now() and qcumplido+0=0')
                ->get(array('comisionid'));
            $comisiones = Comision::where('cedula', $usuario->cedula)
                ->orderby('radicacion', 'desc');
        }
        $comisiones = $comisiones->where('qtrash','0');
        $cantidad = $comisiones->count();
        $comisiones = $comisiones->paginate(15);
        return view('admin.app', compact(['comisiones', 'faltacumplido','cantidad']));
    }

    public function ordenarComisiones(Request $request, $ordenapor)
    {
        $url = explode('?', $request->fullUrl());
        $orden = Session::get('orden');
        $jefe = Session::get('jefe');
        if (!$orden) {
            Session::put('orden', 'desc');
        } else if (empty($url[1])) {
            if (strcmp($orden, 'desc') == 0) {
                $orden = 'asc';
                Session::put('orden', 'asc');
            } else {
                $orden = 'desc';
                Session::put('orden', 'desc');
            }
        }
        $usuario = Auth::user();
        if ($jefe == 1) {
            //Si el usuario es director recupera las comisiones del instituto
            $instituto = Instituto::where('cedulajefe', $usuario->cedula)->orwhere('emailinst', $usuario->email)->first();
            $comisiones = Comision::where('institutoid', $instituto->institutoid)
                ->orderby($ordenapor, $orden)
                ->paginate(15);
        } else if ($jefe == 2) {
            //Si el usuario es decano recupera todas lascomisiones
            $comisiones = Comision::orderby($ordenapor, $orden)
                ->paginate(15);
        } else {
            $comisiones = Comision::where('cedula', $usuario->cedula)
                ->orderby($ordenapor, $orden)
                ->paginate(15);
        }
        return view('admin.app', compact('comisiones'));
    }

    public function mostrarFormularioCrearComision()
    {
        do {
            $randstring = GeneraCaracteres::generarRandomCaracteres(5);            
            $comision = Comision::where('comisionid', $randstring)->get();
        } while (count($comision) > 0);
        return view('comision.crear', compact('tipocom'))->with('random', $randstring)->with('fechaActual', Carbon::now());
    }

    public function crearComision(Request $request)
    {
        $comision = new Comision();        
        $comision->comisionid = $request->comisionid;
        $comision->cedula = Auth::user()->cedula;
        $comision->institutoid = Auth::user()->institutoid;
        if ($request->justificacion) {
            \Storage::disk('local')->put($request->comisionid . '/actividad.txt', $request->justificacion);
        }
        $comision->radicacion = $request->fecharadicacion;
        $comision->actualizacion = $request->fechaactualizacion;
        $comision->estado = 'solicitada';
        $comision->tipocom = $request->tipocom;        
        $comision->actividad = $request->actividad;
        $comision->lugar = $request->lugar;
        $comision->idioma = $request->idioma;

        //capturar archivos y guardar
        if ($request->anexo1) {
            $archivo = $request->file('anexo1');
            $extension = $archivo->getClientOriginalExtension();
            $randstring = GeneraCaracteres::generarRandomCaracteres(5);
            do {
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' . $randstring .'.'.$extension, \File::get($archivo));
            } while (!$ruta);
            $comision->anexo1 = $randstring . '.' . $extension;

        }
        if ($request->anexo2) {
            $archivo = $request->file('anexo2');
            $extension = $archivo->getClientOriginalExtension();
            $randstring = GeneraCaracteres::generarRandomCaracteres(5);
            do {
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' . $randstring .'.'.$extension, \File::get($archivo));
            } while (!$ruta);
            $comision->anexo2 = $randstring .'.'.$extension;
        }
        if ($request->anexo3) {
            $archivo = $request->file('anexo3');
            $extension = $archivo->getClientOriginalExtension();
            $randstring = GeneraCaracteres::generarRandomCaracteres(5);
            do {
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' . $randstring .'.'.$extension, \File::get($archivo));
            } while (!$ruta);
            $comision->anexo3 = $randstring .'.'.$extension;
        }
        
        $comision->vistobueno = 'No';
        $comision->aprobacion = 'No';

//procesado de fecha
        //fecha
        $fecha = $request->fecharango;
        $calendario_meses = array(
            'Jan' => 'Enero',
            'Feb' => 'Febrero',
            'Mar' => 'Marzo',
            'Apr' => 'Abril',
            'May' => 'Mayo',
            'Jun' => 'Junio',
            'Jul' => 'Julio',
            'Aug' => 'Agosto',
            'Sep' => 'Septiembre',
            'Oct' => 'Octubre',
            'Nov' => 'Noviembre',
            'Dec' => 'Diciembre',
        );

        $fecha = explode(' a ', $fecha);

        $array = str_split($fecha[0], 3);
        $array1 = str_split($fecha[1], 3);

        
        $comision->fecha = str_replace($array[0], $calendario_meses[$array[0]], $fecha[0]);
        $comision->fecha .= ' a ' . str_replace($array1[0], $calendario_meses[$array1[0]], $fecha[1]);
        $comision->fecha = str_replace(',', ' de', $comision->fecha);
        
        $comision->fechaini = date_format(date_create($fecha[0]), 'Y-m-d');
        $comision->fechafin = date_format(date_create($fecha[1]), 'Y-m-d');

//termina procesado de fecha

        //días que son de permiso
        if($comision->tipocom=='calamidad' || $comision->tipocom == 'noremunerada'){
            $fecha1 = new DateTime($comision->fechaini);
            $fecha2 = new DateTime($comision->fechafin);
            $resultado = $fecha1->diff($fecha2);
            //Se van a contar los dias que tiene permiso, exceptuando sabado y domingo
            $numeroDeDias = $resultado->d+1;
            $diasPermiso = $resultado->d+1;            
            for($i = 1; $i <= $numeroDeDias; $i++){
                if($fecha1->format('l') == 'Saturday' || $fecha1->format('l')== 'Sunday'){
                    $diasPermiso -= 1;
                }          
                $fecha1->modify("+1 days");            
            }

            //Solo disponen de 3 días de permiso al semestre
            if($diasPermiso > 3){
                return back()->withErrors(['diaspermiso'=>'No se pueden dar '. $diasPermiso . ' dia(s) de permiso. Por favor seleccione una nueva fecha.'])->withInput();
            }
            $anio = date_format(date_create($fecha[0]), 'Y');          
            $diasRestantes = intval($comision->profesor->extra1, 10);
            $diasPermisoRestantes = $diasRestantes - $diasPermiso;
            if($diasPermisoRestantes >= 0){
                $profesor = Profesor::where('cedula', Auth::user()->cedula)->first();
                $profesor->extra1 = $diasPermisoRestantes;
                $profesor->save();
                $comision->extra1 = $diasPermiso;
            }else{
                return back()->withErrors(['diaspermiso'=> 'Ya uso todos los días disponibles para el semestre.'])->withInput();
            }           
        }

        $comision->save();
        $instituto = Instituto::where('institutoid', Auth::user()->institutoid)->first();
        $director = Profesor::where('cedula', $instituto->cedulajefe)->first();
        $secretaria = Profesor::where('email', $instituto->emailinst)->first();
        $correos = array($instituto->emailinst, $director->email);

        //%%%%%%%%%%%%%%%%%%%%%%%%%
        // TODO: enviar correo al director del instituto y a la secretaria del instituto
        //%%%%%%%%%%%%%%%%%%%%%%%%%
        // Mail::to($this->correosprueba)->send(new SolicitudMail($comision));

        Mail::to($correos)->send(new SolicitudMail($comision));//

        return redirect('/inicio')->with(['notificacion1'=>'Notificación enviada a Director '.$director->email,
                                          'notificacion2'=>'Una copia ha sido enviada también a Secretaria Instituto '. $secretaria->email]);
    }    

    public function mostrarFormularioActualizaComision($comisionid)
    {
        $instituto = Instituto::where('cedulajefe', Auth::user()->cedula)->first();

        $comision = Comision::where('comisionid', $comisionid)->first();
        if (\Storage::disk('local')->exists($comisionid . '/actividad.txt')) {
            $comision->justificacion = \Storage::disk('local')->get($comisionid . '/actividad.txt');
        }
        if (\Storage::disk('local')->exists($comisionid . '/respuesta.txt')) {
            $comision->respuesta = \Storage::disk('local')->get($comisionid . '/respuesta.txt');
        }
        $comision->fechaini = date_format(date_create($comision->fechaini), 'M d, Y');
        $comision->fechafin = date_format(date_create($comision->fechafin), 'M d, Y');

        return view('comision.actualizar')
            ->with('comision', $comision)
            ->with('fechaActual', Carbon::now());
    }

    public function actualizarComision(Request $request, $id)
    {
        $calendario_meses = array(
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre',
        );
        $comision = Comision::where('comisionid', $id)->first();
        $jefe = Session::get('jefe');
        $comision->actualiza = Auth::user()->cedula;
        $comision->actualizacion = $request->fechaactualizacion;

        $destino = '';
        // Devolución de la comisión
        if ($jefe > 0 && strcmp($request->devolucion, 'Si') == 0 && $comision->estado != 'devuelta') {
            $comision->estado = 'devuelta';
            $comision->vistobueno = 'No';
            $comision->aprobacion = "No";
            \Storage::disk('local')->put($comision->comisionid . '/respuesta.txt', $request->respuesta);
            
            $profesor = Profesor::where('cedula', $comision->cedula)->first();
            $instituto = Instituto::where('institutoid', $profesor->institutoid)->first();
            $directorInstituto = Profesor::where('cedula', $instituto->cedulajefe)->first();
            $correos = array($instituto->emailinst, $directorInstituto->email);
            
            //%%%%%%%%%%%%%%%%%%%%%%%%%
            // TODO: enviar correo al director del instituto y a la secretaria del instituto
            //%%%%%%%%%%%%%%%%%%%%%%%%%

            // Mail::to('jhndagon12@gmail.com')->send(new DevolucionDirectorMail($comision,$request->respuesta));
            // Mail::to('jhndagon11@gmail.com')->send(new DevolucionMail($comision, $request->respuesta));
            
            Mail::to($profesor->email)->send(new DevolucionMail($comision, $request->respuesta));
            Mail::to($directorInstituto->email)->send(new DevolucionDirectorMail($comision, $request->respuesta));
            $destino = "Solicitante";
            $emailjefe = $profesor->email;

            $copia = "Director Instituto";
            $emailcopia = $directorInstituto->email;

        } else {
            if ($jefe == 1 || $jefe == 2) {
                if ($comision->vistobueno == 'No' && $request->vistobueno == 'Si') {
                    $comision->vistobueno = $request->vistobueno;
                    $comision->estado = 'vistobueno';

                    $instituto = Instituto::where('institutoid', 'decanatura')->first();
                    $decano = Profesor::where('cedula', $instituto->cedulajefe)->first();
                    $secretariaDecanato = $instituto->emailinst;
                    $profesor = Profesor::where('cedula', $comision->cedula)->first();
                    
                    //%%%%%%%%%%%%%%%%%%%%%%%%%
                    // TODO: enviar correo al decano y a la secretaria del decano
                    //%%%%%%%%%%%%%%%%%%%%%%%%%

                    $correos = array($instituto->emailinst, $decano->email);


                    // Mail::to($this->correosprueba[0])->send(new VistoBuenoMail($comision));
                    // Mail::to($this->correosprueba[1])->send(new NotificacionActualizacionProfesorMail($comision));

                    Mail::to($correos)->send(new VistoBuenoMail($comision));  
                    Mail::to($profesor->email)->send(new NotificacionActualizacionProfesorMail($comision));
                    
                    $destino = "Decano";
                    $emailjefe = $decano->email;

                    $copia = "Secretaria Decanato";
                    $emailcopia = $secretariaDecanato;

                }
            }
            if ($jefe == 2) {
                if ($comision->aprobacion == 'No' && $request->aprobacion == 'Si') {
                    $comision->aprobacion = $request->aprobacion;
                    $comision->estado = 'aprobada';

                    if ($comision->tipocom != "noremunerada" and $comision->tipocom != "calamidad") {                        
                        $resolucion = new Resolucion();
                        $resolucion->comisionid = $comision->comisionid;
                        $resolucion->save();
                        $comision->resolucion = $resolucion->resolucionid;
                    }else{
                        $comision->resolucion = '99999';
                    }
                    
                    $fecha = Carbon::now();
                    $fecha1 = $fecha->format('d \d\e ') . $calendario_meses[$fecha->format('F')] . $fecha->format(' \d\e Y');
                    $comision->fecharesolucion = $fecha1;

                    //generar resolucion y envio de correo a secretaria de decana y a profesor
                    if (!\Storage::disk('local')->exists($comision->comisionid)) {
                        \Storage::makeDirectory($comision->comisionid);
                    }

                    $profesor = Profesor::where('cedula', $comision->cedula)->first();
                    $instituto = Instituto::where('institutoid', $comision->institutoid)->first();
                    $director = Profesor::where('cedula', $instituto->cedulajefe)->first();


                    $destino = "Solicitante";
                    $emailjefe = $profesor->email;    
                    $copia = "Director Instituto";
                    $emailcopia = $director->email;


                    if (strcmp($comision->tipocom, 'calamidad') == 0 || strcmp($comision->tipocom, 'noremunerada') == 0) {
                        $pdfResolucion = PDF::loadView('resoluciones.resolucionPermiso', ['comision' => $comision, 'blank' => 1])
                            ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-blank-' . $comision->comisionid . '.pdf');

                        $pdfResolucion = PDF::loadView('resoluciones.resolucionPermiso', ['comision' => $comision, 'blank' => 0])
                            ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-' . $comision->comisionid . '.pdf');


                        //%%%%%%%%%%%%%%%%%%%%%%%%%
                        // TODO: enviar correo al solicitante y copia al director
                        //%%%%%%%%%%%%%%%%%%%%%%%%%

                        // Mail::to('jhndagon11@gmail.com')->send(new AprobacionPermisoMail($comision));
                        // Mail::to('jhndagon12@gmail.com')->send(new AprobacionPermisoDirectorMail($comision));

                        Mail::to($profesor->email)->send(new AprobacionPermisoMail($comision, false));
                        Mail::to($director->email)->send(new AprobacionPermisoDirectorMail($comision,true)); //esta envia la copía de aprobación al director
                        
                    } else {
                        $pdfResolucion = PDF::loadView('resoluciones.resolucion', ['comision' => $comision, 'blank' => 1, 'profesor'=>$comision->profesor])
                            ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-blank-' . $comision->comisionid . '.pdf');

                        $pdfResolucion = PDF::loadView('resoluciones.resolucion', ['comision' => $comision, 'blank' => 0, 'profesor'=>$comision->profesor])
                            ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-' . $comision->comisionid . '.pdf');

                        //%%%%%%%%%%%%%%%%%%%%%%%%%
                        // TODO: enviar correo al solicitante y copia al director
                        //%%%%%%%%%%%%%%%%%%%%%%%%%
                      
                        // Mail::to('jhndagon11@gmail.com')->send(new AprobacionMail($comision));
                        // Mail::to('jhndagon12@gmail.com')->send(new AprobacionDirectorMail($comision));                        
                                            
                        Mail::to($profesor->email)->send(new AprobacionMail($comision));
                        Mail::to($director->email)->send(new AprobacioDirectorMail($comision));//esta envia la copía de aprobación al director
                        
                    }

                }

            } else {
                $profesor = Profesor::where('cedula', $comision->cedula)->first();
                if($comision->estado == 'devuelta' ){
                    $comision->estado = 'solicitada';
                    $profesor->extra1 = intval($profesor->extra1,10) + intval($comision->extra1,10);
                    $profesor->save();
                }
                //procesado de fecha
                //fecha        
                $fecha = $request->fecharango;
                $calendario_meses = array(
                    'Jan' => 'Enero',
                    'Feb' => 'Febrero',
                    'Mar' => 'Marzo',
                    'Apr' => 'Abril',
                    'May' => 'Mayo',
                    'Jun' => 'Junio',
                    'Jul' => 'Julio',
                    'Aug' => 'Agosto',
                    'Sep' => 'Septiembre',
                    'Oct' => 'Octubre',
                    'Nov' => 'Noviembre',
                    'Dec' => 'Diciembre',
                );        
                $fecha = explode(' a ', $fecha);        
                $array = str_split($fecha[0], 3);
                $array1 = str_split($fecha[1], 3);        
                $comision->fecha = str_replace($array[0], $calendario_meses[$array[0]], $fecha[0]);
                $comision->fecha .= ' a ' . str_replace($array1[0], $calendario_meses[$array1[0]], $fecha[1]);
                $comision->fecha = str_replace(',', ' de', $comision->fecha);        
                $fechaini = date_format(date_create($fecha[0]), 'Y-m-d');
                $fechafin = date_format(date_create($fecha[1]), 'Y-m-d'); 
                  

                $comision->tipocom = $request->tipocom;
                $comision->lugar = $request->lugar;
                $comision->actividad = $request->actividad;
                $comision->idioma = $request->idioma;
                if ($request->justificacion) {
                    \Storage::disk('local')->put($request->comisionid . '/actividad.txt', $request->justificacion);
                }
                if(($comision->tipocom == 'noremunerada' || $comision->tipocom == 'calamidad')){
                    $fecha1 = new DateTime($comision->fechaini);
                    $fecha2 = new DateTime($comision->fechafin);

                    $resultado = $fecha1->diff($fecha2);
                    //Se van a contar los dias que tiene permiso, exceptuando sabado y domingo
                    $numeroDeDias = $resultado->d+1;
                    $diasPermiso = $resultado->d+1;            
                    for($i = 1; $i <= $numeroDeDias; $i++){
                        if($fecha1->format('l') == 'Saturday' || $fecha1->format('l')== 'Sunday'){
                            $diasPermiso -= 1;
                        }          
                        $fecha1->modify("+1 days");            
                    }
        
                    //Solo disponen de 3 días de permiso al semestre
                    if($diasPermiso > 3){
                        return back()->withErrors(['diaspermiso'=>'No se pueden dar '. $diasPermiso . ' dia(s) de permiso. Por favor seleccione una nueva fecha.'])->withInput();
                    }              
        
                    $anio = date_format(date_create($fecha[0]), 'Y');
                    // $diasUsados = Comision::where('cedula', Auth::user()->cedula)
                    //                         ->where(function($q){
                    //                             $q->where('tipocom', 'noremunerada')
                    //                               ->orwhere('tipocom', 'calamidad');
                    //                         })
                    //                         ->where(function($q){
                    //                             $q->where('estado', 'apobada')
                    //                               ->orwhere('estado', 'cumplida');
                    //                         })
                    //                         ->where('actualizacion', 'like', $anio)                                    
                    //                         ->sum('extra1');
                    $diasRestantes = intval($profesor->extra1, 10);
                    $diasPermisoRestantes = $diasRestantes - $diasPermiso;
                    if($diasPermisoRestantes >= 0){
                        $profesor->extra1 = $diasPermisoRestantes;
                        $profesor->save();
                        $comision->extra1 = $diasPermiso;
                    }else{
                        return back()->withErrors(['diaspermiso'=> 'Ya uso todos los días disponibles para el semestre'])->withInput();
                    }   
                }
            }
        }

        $comision->save();
        if($destino!=''){
            return redirect('/inicio')->with(['notificacion1'=>'Notificación enviada a '. $destino . ' ' . $emailjefe,
                                                'notificacion2'=>'Una copia ha sido enviada también a '. $copia . ' '.$emailcopia]);
        }
        else{
            return redirect('/inicio');
        }

    
    }

    public function reciclajeComisiones(){
        $comisiones = Comision::where('qtrash', '1');
        $cantidad = $comisiones->count();
        $comisiones = $comisiones->get();
        return view('admin.app', compact(['comisiones','cantidad']));
    }

    public function reciclarComision($id){
        $comision = Comision::where('comisionid', $id)->first();
        $comision->qtrash = 1;
        $comision->save();
        return redirect('/inicio')->with(['notificacion1'=>'Comision '.$id.' reciclada.']);
    }

    public function eliminarComision($id)
    {
        $comision = Comision::where('comisionid', $id)->first();
        if($comision->tipocom =='noremunerada' || $comision->tipocom =='calamidad'){
            $profesor = Profesor::where('cedula', Auth::user()->cedula)->first();
            $profesor->extra1 = intval($profesor->extra1,10) + intval($comision->extra1,10);
            $profesor->save();
        }
        $comision->delete();
        //eliminar carpeta de la comision
        \Storage::disk('local')->deleteDirectory($id);
        return redirect('/inicio');
    }
}
