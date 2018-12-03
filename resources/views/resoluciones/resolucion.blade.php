<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        BODY {
            font-size: 12px;
            font-family: Times;
        }

        td {
            font-size: 18px;
            font-family: Times;
        }
    </style>
</head>

<body>

    <table border=0 width="650px" style="border-collapse:collapse;margin-left:25px">
        <tr>
            <td width=10%>
                @if ($blank)
                    <img src="{{ base_path('public/images/') .'udea-fake.jpg'}}" width=100>   
                @else
                    <img src="{{ base_path('public/images/') .'udea.jpg'}}" width=100>     
                @endif
            </td>
            <td width=20%></td>
            <td width=40% style='text-align:center'>
                <b>FACULTAD DE CIENCIAS EXACTAS<br/>Y NATURALES</b>
            </td>
        </tr>
    </table>

    <table border=0 width="650px" style="border-collapse:collapse;margin-left:25px">
        <tr>
            <td>

                <div style="height:40px"></div>

                <p style='text-align:center;font-weight:bold'>
                    RESOLUCION DE DECANATO {{$comision->resolucion}}
                </p>

                <p style='text-align:center;font-weight:bold'>
                    PARA LA CUAL SE CONCEDE UNA COMISIÓN DE TIPO {{strtoupper($comision->tipocom)}}
                </p>

                <p align="justify">
                    LA DECANA DE LA FACULTAD DE CIENCIAS EXACTAS Y NATURALES en uso de sus atribuciones conferidas mediante artículo 53, literal
                    ñ del Acuerdo Superior Nro. 1 de 1994.
                </p>

                <p style='text-align:center;font-weight:bold'>
                    RESUELVE:
                </p>

                <p align="justify">
                    <b>ARTÍCULO ÚNICO</b>: Conceder al profesor <b>{{$profesor->nombre}}</b> {{$profesor->tipoid}} {{$profesor->cedula}}, {{$profesor->tipo}} de {{ucfirst($profesor->institutoid)}},
                    comisión de {{$comision->fecha}} para {{$comision->actividad}} a realizarse en {{$comision->lugar}}.
                </p>

                <p align="justify">
                    <i>
Al reintegrarse a sus actividades deberá presentar ante la oficina de
la Decanato de la Facultad, constancias que acrediten su cumplimiento.
</i>
                </p>

                <p style='text-align:center;font-weight:bold'>
                    COMUNÍQUESE Y CÚMPLASE
                </p>

                <p>
                    Dada en Medellín el {{$comision->fecharesolucion}}.
                </p>
                <p>
                    @if ($blank)
                    <img src="{{ base_path('public/images/') .'decano-fake.jpg'}}" width=300px><br/>
                  @else
                    <img src="{{ base_path('public/images/') .'decano.jpg'}}" width=300px><br/>
                  @endif
                    
                    <!--<b>NORA EUGENIA RESTREPO SÁNCHEZ</b><br/>-->
                    <b>ADRIANA ECHAVARRIA ISAZA</b>, decana,<br/>Facultad de Ciencias Exactas y Naturales
                </p>

                <!--
<p style="font-size:14px">
Copia: $COORDINADOR, $COORDINADORTXT de Talento Humano<br/>Archivo.
</p>
-->

            </td>
        </tr>
    </table>
</body>

</html>