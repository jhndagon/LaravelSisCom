{{-- Esta plantilla representa el correo a enviar cuando se aproueba una comision --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Devolucion de comisón</title>
</head>

<body>
    <p>Se&ntilde;or(a) Empleado(a),</p>
    <p>
        Su solicitud de comisión/permiso radicada en el <a href='{{ url('') }}'>Sistema de Solicitudes</a> en fecha
        {{$comision->radicacion}} e identificada con número {{$comision->comisionid}} ha sido aprobada.
    </p>
    <p>
        El número de resolución de decanato es el <b>{{$comision->resolucion}} de {{$comision->fecharesolucion}}</b>.
    </p>
    <p>
        Para obtener una copia de la resolución de click en <a href="{{ url('/archivo', ['comisionid' => $comision->comisionid, 'documento' => 'resolucion-'.$comision->comsionid.'.pdf' ]) }}">este enlace</a> o en <a href="{{ url('/archivo', ['comisionid' => $comision->comisionid, 'documento' => 'resolucion-blank-'.$comision->comsionid.'.pdf' ]) }}""> este enlace </a>para obtener la resolucion imprimible.
        En caso de que el enlace este roto (no se haya expedido la resolución) pregunte en la vicedecanatura por la misma
        o espere a que el link aparezca en el Sistema de Solicitudes.
    </p>
    <b>Sistema de Solicitud de Comisiones<br/>
        Decanato, FCEN
    </b>
</body>

</html>
