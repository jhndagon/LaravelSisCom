{{-- Este documento representa la platilla de correo cuando un profesor crea una comisión. --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud de comisión</title>
</head>

<body>
    <p>Se&ntilde;or(a) Director(a),</p>
    <p>Una nueva solicitud de comisión ha sido radicada en el <a href="">Sistema de comisiones</a>. Está es la información basica
        de la solicitud: </p>
    <ul>
        <li>Fecha de radicacion: {{$comision->fecharadicacion}}</li>
        <li>Tipo de comision: {{$comision->tipocom}}</li>
        <li>Cédula: {{ $comision->profesor['cedula'] }}</li>
        <li>Nombre: {{ $comision->profesor['nombre'] }}</li>
    </ul>

    <p>
        Por favor evalue la solicitud y en caso de ser necesario otorgue su visto bueno para continuar con el trámite.
    </p>
    <b>Sistema de Solicitud de Comisiones<br/>
    Decanato, FCEN</b>
</body>

</html>