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
                ->orderby('radicacion', 'desc')
                ->paginate(15);
        } else if ($jefe == 2) {
            //Si el usuario es decano recupera todas las comisiones
            $comisiones = Comision::orderby('radicacion', 'desc')
                ->paginate(15);
        } else {
            $faltacumplido = Comision::whereRaw('(tipocom<>"noremunerada" and tipocom<>"calamidad") and cedula=' . $usuario->cedula . ' and fechafin<now() and qcumplido+0=0')
                ->get(array('comisionid'));
            $comisiones = Comision::where('cedula', $usuario->cedula)
                ->orderby('radicacion', 'desc')
                ->paginate(15);
        }
        return view('admin.app', compact(['comisiones', 'faltacumplido']));
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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            $randstring = '';
            for ($i = 0; $i < 5; $i++) {
                $randstring .= $characters[rand(0, strlen($characters) - 1)];
            }
            $comision = Comision::where('comisionid', $randstring)->get();
        } while (count($comision) > 0);
        return view('comision.crear', compact('tipocom'))->with('random', $randstring)->with('fechaActual', Carbon::now());
    }

    public function crearComision(Request $request)
    {
        $comision = new Comision();        
        $comision->comisionid = $request->comisionid;
        //cedula
        $comision->cedula = Auth::user()->cedula;
        //institutoid
        $comision->institutoid = Auth::user()->institutoid;
        if ($request->justificacion) {
            \Storage::disk('local')->put($request->comisionid . '/actividad.txt', $request->justificacion);
        }
        $comision->radicacion = $request->fecharadicacion;
        $comision->actualizacion = $request->fechaactualizacion;
        $comision->estado = 'solicitada';
        //tipocom
        $comision->tipocom = $request->tipocom;        
        //actividad
        $comision->actividad = $request->actividad;
        //lugar
        $comision->lugar = $request->lugar;
        //idioma
        $comision->idioma = $request->idioma;

        //capturar archivos y guardar
        if ($request->anexo1) {
            $archivo = $request->file('anexo1');
            $nombre = $archivo->getClientOriginalName();
            do {
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' . $nombre, \File::get($archivo));
            } while (!$ruta);
            $comision->anexo1 = $nombre;
        }
        if ($request->anexo2) {
            $archivo = $request->file('anexo2');
            $nombre = $archivo->getClientOriginalName();
            do {
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' . $nombre, \File::get($archivo));
            } while (!$ruta);
            $comision->anexo2 = $nombre;
        }
        if ($request->anexo3) {
            $archivo = $request->file('anexo3');
            $nombre = $archivo->getClientOriginalName();
            do {
                $ruta = \Storage::disk('local')->put($request->comisionid . '/' . $nombre, \File::get($archivo));
            } while (!$ruta);
            $comision->anexo3 = $nombre;
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
            $diasUsados = Comision::where('cedula', Auth::user()->cedula)
                                    ->where(function($q){
                                        $q->where('tipocom', 'noremunerada')
                                          ->orwhere('tipocom', 'calamidad');
                                    })
                                    ->where(function($q){
                                        $q->where('estado', 'apobada')
                                          ->orwhere('estado', 'cumplida');
                                    })
                                    ->where('actualizacion', 'like', $anio)                                    
                                    ->sum('extra1');            
            $diasRestantes = intval($comision->profesor->extra1, 10);
            $diasPermisoRestantes = $diasRestantes - $diasPermiso;
            if($diasPermisoRestantes >= 0){
                $profesor = Profesor::where('cedula', Auth::user()->cedula)->first();
                $profesor->extra1 = $diasPermisoRestantes;
                $profesor->save();
                $comision->extra1 = $diasPermiso;
            }else{
                return back()->withErrors(['diaspermiso'=> 'Ya uso todos los días disponibles para el semestre'])->withInput();
            }           
        }

        //$comision->save();
        dd('Insertada en la base de datos');
        $instituto = Instituto::where('institutoid', Auth::user()->institutoid)->first();
        $director = Profesor::where('cedula', $instituto->cedulajefe)->first();
        $correos = array($instituto->emailinst, $director->email);
        if (env('APP_DEBUG')) {
            //enviar correo de prueba            
             Mail::to($this->correosprueba)->send(new SolicitudMail($comision));
        } else {
            // TODO: enviar correo al director del instituto y a la secretaria del instituto
            //Mail::to($this->correosprueba)->send(new SolicitudMail($comision));
            //dd('envio de correo a jefe de instituto y secretaria', $correos);
            //Mail::to($correos)->send(new SolicitudMail($comision));
        }
        return redirect('/inicio');
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

        //devolucion
        if ($jefe > 0 && strcmp($request->devolucion, 'Si') == 0) {
            $comision->estado = 'devuelta';
            $comision->vistobueno = 'No';
            $comision->aprobacion = "No";
            \Storage::disk('local')->put($comision->comisionid . '/respuesta.txt', $request->respuesta);
            if (env('APP_DEBUG')) {
                //enviar correo de prueba
                Mail::to($this->correosprueba)->send(new DevolucionMail($comision, $request->respuesta));
            } else {
                //enviar correo a profesor devolucion
                $correoProfesor = Profesor::where('cedula', $comision->cedula)->first()->email;
                //dd('Envío de correo respuesta devolviendo comisión al profesor', $correoProfesor);
                Mail::to($correoProfesor)->send(new DevolucionMail($comision, $request->respuesta));
            }
        } else {
            if ($jefe == 1) {
                if ($comision->vistobueno == 'No' && $request->vistobueno == 'Si') {
                    $comision->vistobueno = $request->vistobueno;
                    $comision->estado = 'vistobueno';
                    //envio de correo a decanato y secretaria de decanato
                    if (env('APP_DEBUG')) {
                        //enviar correo de prueba
                        Mail::to($this->correosprueba)->send(new VistoBuenoMail($comision));
                    } else {
                        // TODO: agregar envio de correo a decanato
                        //enviar correo a decanato y a la secretaria de decanato
                        $instituto = Instituto::where('institutoid', 'decanatura')->first();
                        $correoDecanato = Profesor::where('cedula', $instituto->cedulajefe)->first()->email;
                        $correoSecretariaDecanato = $instituto->emailinst;
                        //dd('Envío de correo al decanato luego de vistobueno',array($correoDecanato, $correoSecretariaDecanato));
                        Mail::to(array($correoDecana, $correoSecretariaDecanato))->send(new VistoBuenoMail($comision));
                    }
                }
            } else if ($jefe == 2) {
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
                    $correoProfesorDeComision = Profesor::where('cedula', $comision->cedula)->first()->email;
                    if (strcmp($comision->tipocom, 'calamidad') == 0 || strcmp($comision->tipocom, 'noremunerada') == 0) {
                        $pdfResolucion = PDF::loadView('resoluciones.resolucionPermiso', ['comision' => $comision, 'blank' => 1])
                            ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-blank-' . $comision->comisionid . '.pdf');

                        $pdfResolucion = PDF::loadView('resoluciones.resolucionPermiso', ['comision' => $comision, 'blank' => 0])
                            ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-' . $comision->comisionid . '.pdf');

                        //envio de correo
                        if (env('APP_DEBUG')) {
                            //enviar correo de prueba
                            Mail::to($this->correosprueba)->send(new AprobacionPermisoMail($comision));
                        } else {
                            
                            //enviar correo a empleado
                            //dd('Correo de permiso enviado a: ',$correoProfesorDeComision);
                            Mail::to($correoProfesorDeComision)->send(new AprobacionPermisoMail($comision));
                        }
                    } else {
                        $pdfResolucion = PDF::loadView('resoluciones.resolucion', ['comision' => $comision, 'blank' => 1, 'profesor'=>$comision->profesor])
                            ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-blank-' . $comision->comisionid . '.pdf');

                        $pdfResolucion = PDF::loadView('resoluciones.resolucion', ['comision' => $comision, 'blank' => 0, 'profesor'=>$comision->profesor])
                            ->save(storage_path('app/comisiones') . '/' . $comision->comisionid . '/resolucion-' . $comision->comisionid . '.pdf');

                        //envio de correo a decana y secretaria de decana
                        if (env('APP_DEBUG', false)) {
                            //enviar correo de prueba
                            Mail::to($this->correosprueba)->send(new AprobacionMail($comision));
                        } else {                            
                            //enviar correo a decana y a la secretaria de decana
                            dd('Correo de comision enviado a: ',$correoProfesorDeComision);
                            $correos = array();
                        
                            Mail::to($correoProfesorDeComision)->send(new AprobacionMail($comision));
                            
                        }
                    }

                }

            } else {
                if($comision->estado == 'devuelta' ){
                    $comision->estado = 'solicitada';
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
                $comision->fechaini = date_format(date_create($fecha[0]), 'Y-m-d');
                $comision->fechafin = date_format(date_create($fecha[1]), 'Y-m-d');   

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
                    $diasUsados = Comision::where('cedula', Auth::user()->cedula)
                                            ->where(function($q){
                                                $q->where('tipocom', 'noremunerada')
                                                  ->orwhere('tipocom', 'calamidad');
                                            })
                                            ->where(function($q){
                                                $q->where('estado', 'apobada')
                                                  ->orwhere('estado', 'cumplida');
                                            })
                                            ->where('actualizacion', 'like', $anio)                                    
                                            ->sum('extra1');            
                    $diasRestantes = intval($comision->profesor->extra1, 10);
                    $diasPermisoRestantes = $diasRestantes - $diasPermiso;
                    if($diasPermisoRestantes >= 0){
                        $profesor = Profesor::where('cedula', Auth::user()->cedula)->first();
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
        return redirect('inicio');
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
