{{-- Este documento representa la platilla de correo cuando el director de instituto da el vistobueno a una comisión. --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Visto bueno director</title>
</head>

<body>
    <p>Se&ntilde;or(a) Decano(a),</p>
    <p>
        La solicitud radicada en el <a href='{{ url('') }}'>Sistema
        de Solicitudes</a> identificada con número {{$comision->comisionid}} ha recibido visto bueno del Director de Instituto.
    </p>
    <p>
        Por favor evalue la solicitud y en caso de ser necesario otorgue su aprobación para continuar con el trámite.
    </p>
    <b>Sistema de Solicitud de Comisiones<br/>
        Decanato, FCEN
    </b>
</body>

</html>
