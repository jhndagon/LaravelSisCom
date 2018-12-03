<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <style type="text/css">
  BODY{
  font-size:12px;
  font-family:Times;
  }
  td{
  font-size:18px;
  font-family:Times;
  }
  </style>
</head>

<body>

<table border=0 width='650px' style="'border-collapse:collapse;margin-left:25px'">
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

<table border=0 width='650px' style="'border-collapse:collapse;margin-left:25px'">
<tr><td>

<div style="height:40px"></div>

<p>
Medellín, {{ $comision->fecharesolucion }}
</p>

<br style="margin-bottom:2em"/>

<p>
Señor(a)<br/>
<b>{{ $comision->profesor->nombre }}</b><br/>
Facultad de Ciencias Exactas y Naturales<br/>
Ciudad
</p>

<br style="margin-bottom:2em"/>

<p>
Cordial saludo,
</p>

<p align="justify">
La Decana de la Facultad de Ciencias Exactas y Naturales y en uso de
las atribuciones conferidas mediante el artículo 53 literal ñ del
Acuerdo Superior No. 1 de 1994, se le concede permiso durante el(los) día(s)
{{$comision->fecha}} para asuntos de índole personal.
</p>

<br style="margin-bottom:2em"/>

<p>
Atentamente,
</p>

<br style="margin-bottom:2em"/>

<p>
    @if ($blank)
      <img src="{{ base_path('public/images/') .'decano-fake.jpg'}}" width=300px><br/>
    @else
      <img src="{{ base_path('public/images/') .'decano.jpg'}}" width=300px><br/>
    @endif
<b>ADRIANA ECHAVARRIA ISAZA</b>, decana,<br/>
Decana, Facultad de Ciencias Exactas y Naturales
</p>

</td></tr>
</table>
</body>
</html>