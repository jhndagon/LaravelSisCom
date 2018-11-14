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

    <table border=0 width=$tablewidth style=$tablestyle>
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

    <table border=0 width=$tablewidth style=$tablestyle>
        <tr>
            <td>

                <div style="height:$vspace"></div>

                <p style=$titlestyle>
                    RESOLUCION DE DECANATO $resolucion
                </p>

                <p style=$titlestyle>
                    PARA LA CUAL SE CONCEDE UNA $rtipocom
                </p>

                <p align="justify">
                    LA DECANA DE LA FACULTAD DE CIENCIAS EXACTAS Y NATURALES en uso de sus atribuciones conferidas mediante artículo 53, literal
                    ñ del Acuerdo Superior Nro. 1 de 1994.
                </p>

                <p style=$titlestyle>
                    RESUELVE:
                </p>

                <p align="justify">
                    <b>ARTÍCULO ÚNICO</b>: Conceder al profesor <b>$rnombre</b> $rtipoid $cedula, $rtipo del $rinstituto,
                    comisión de $fecha para $actividad a realizarse en $lugar.
                </p>

                <p align="justify">
                    <i>
Al reintegrarse a sus actividades deberá presentar ante la oficina de
la Decanato de la Facultad, constancias que acrediten su cumplimiento.
</i>
                </p>

                <p style=$titlestyle>
                    COMUNÍQUESE Y CÚMPLASE
                </p>

                <p>
                    Dada en Medellín el $fecharesolucion.
                </p>
                <p>
                    @if ($blank)
                    <img src="{{ base_path('public/images/') .'decano-fake.jpg'}}" width=300px><br/>
                  @else
                    <img src="{{ base_path('public/images/') .'decano.jpg'}}" width=300px><br/>
                  @endif
                    
                    <!--<b>NORA EUGENIA RESTREPO SÁNCHEZ</b><br/>-->
                    <b>ADRIANA ECHAVARRIA ISAZA</b><br/> $DECANOTXT, Facultad de Ciencias Exactas y Naturales
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