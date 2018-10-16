<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Señor@ director@</p>
    <p>Una nueva solicitud de comisión ha sido radicada  en el <a href="">Sistema de comisiones</a>. Está es la 
    información basica de la solicitud: </p>
    <li>
    <ul>Fecha de radicacion: {{$comision->fecharadicacion}}</ul>
    <ul>Tipo de comision: {{$comision->tipocom}}</ul>
    <ul>Cédula: {{ $comision->profesor['cedula'] }}</ul>
    <ul>Nombre: {{ $comision->profesor['nombre'] }}</ul>
    </li>
    
</body>
</html>