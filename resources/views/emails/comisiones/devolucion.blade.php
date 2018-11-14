{{-- Esta plantilla representa correo cuando una comisón es devuelta --}}
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
        La solicitud radicada en el <a href='bit.ly/fcen-comisiones'>Sistema
            de Solicitudes</a> identificada con número '$comisionid' ha sido devuelta. La razón de la devolución se reproduce
        abajo:
    </p>
    <blockquote>
        {{-- Mostrar respuesta de devolcuión --}}
    </blockquote>
    <p>
        Vaya al sistema y modifique la solicitud de acuerdo a las sugerencias indicadas.
    </p>
    <b>Sistema de Solicitud de Comisiones<br/>
        Decanato, FCEN
    </b>
</body>

</html>