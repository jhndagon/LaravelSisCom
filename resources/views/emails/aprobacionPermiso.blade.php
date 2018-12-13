{{-- Esta plantilla representa el correo a enviar cuando se aproueba una comision de permiso o calamidad--}}
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
        Su solicitud de comisión/permiso radicada en el <a href='{{url('/inicio')}}'>Sistema de Solicitudes</a> en fecha
        {{$comision->radicacion}} e identificada con número {{$comision->comisionid}} ha sido aprobada.
    </p>


    <b>Sistema de Solicitud de Comisiones<br/>
        Decanato, FCEN
    </b>
</body>

</html>

