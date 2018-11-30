<?php
$COLORS=array(
    "solicitada"=>"#FFFF99",
    "solicitada_noremunerada"=>"#FFCC99",
    "vistobueno"=>"#99CCFF",
    "vistobueno_noremunerada"=>"#99CCFF",
    "devuelta"=>"#FF99FF",
    "devuelta_noremunerada"=>"#FF99FF",
    "aprobada"=>"#00CC99",
    "aprobada_noremunerada"=>"#33CCCC",
    "cumplida"=>"lightgray"
);
$estadocolor='';
?>

@extends('admin.layout') 
@section('contenido')

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"></li>
            <table>
                <tr>
                    <td>Convenciones:</td>
                </tr>
                <tr>
                    <td style=background:#FFFF99>Comisión Solicitada</td>
                    <td style=background:#FFCC99>Permiso Solicitado</td>
                    <td style=background:#99CCFF>Visto Bueno</td>
                    <td style=background:#33CCCC>Permiso Aprobado</td>
                    <td style=background:#00CC99>Comisión Aprobada</td>
                    <td style=background:lightgray>Comisión Cumplida</td>
                    <td style=background:pink>Falta Cumplido</td>
                </tr>
            </table>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th><a href="{{url('inicio', 'comisionid')}}">Comisión</a></th>
                                <th><a href="{{url('inicio', 'radicacion')}}">Radicación</a></th>
                                <th><a href="{{url('inicio', 'actualizacion')}}">Actualización</a></th>
                                <th><a href="{{url('inicio')}}">Fechas</a></th>
                                <th><a href="{{url('inicio', 'estado')}}">Estado</a></th>
                                <th><a href="{{url('inicio', 'institutoid')}}">Instituto</a></th>
                                <th>Solicitante</th>
                                <th>Descargas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($comisiones as $comision)
                            <?php
                                $estadocolor = $COLORS[$comision->estado];
                                if ($comision->tipocom == "noremunerada" || $comision->tipocom== "calamidad") {
                                    $estadocolor = $COLORS[$comision->estado . "_noremunerada"];
                                } 
                                $d1 = new DateTime($comision->fechafin);
                                $d2 = new DateTime(date('Y-m-d'));
                                                         
                               
                                if($d2>$d1 && ($comision->estado=='aprobada') && $comision->tipocom !='noremunerada'){
                                    $estadocolor= 'pink';
                                }
                                
                                
                            ?>

                            <tr bgcolor={{$estadocolor}}>
                                <td>
                                    <a href="{{ url('comision', $comision->comisionid) }}">
                                        {{$comision->comisionid}}
                                    </a>
                                </td>
                                <td>{{$comision->radicacion}}</td>
                                <td>{{$comision->actualizacion}} <br> {{$comision->actualiza}}</td>
                                <td>{{$comision->fechaini}}<br>{{ $comision->fechafin}}</td>
                                <td>{{$comision->estado}}</td>
                                <td>{{ucfirst($comision->institutoid)}}</td>
                                <td>{{$comision->profesor['nombre']}}</td>
                                <td>
                                    @if ($comision->anexo1)
                                    <a target="_black" href="{{url('/archivo/'.$comision->comisionid . '/' . $comision->anexo1)}}">Anexo 1</a><br>                                    
                                    @endif 
                                    @if ($comision->anexo2)
                                    <a target="_black" href="{{url('/archivo/'.$comision->comisionid . '/' . $comision->anexo2)}}">Anexo 2</a><br>                                    
                                    @endif 
                                    @if ($comision->anexo3)
                                    <a target="_black" href="{{url('/archivo/'.$comision->comisionid . '/' . $comision->anexo3)}}">Anexo 3</a><br>                                    
                                    @endif
                                    @if ($comision->fecharesolucion)
                                    <a target="_black" href="{{url('/archivo/'.$comision->comisionid . '/resolucion-blank-'.$comision->comisionid .'.pdf' )}}">Imprimible</a><br>                                    
                                    <a target="_black" href="{{url('/archivo/'.$comision->comisionid . '/resolucion-'.$comision->comisionid .'.pdf' )}}">Resolucion</a><br>                                    
                                    @endif
                                    

                                </td>
                                <td>
                                    @if ($comision->estado == 'solicitada' && Auth::user()->cedula == $comision->cedula)
                                    <a href="{{ url('eliminarComision', $comision->comisionid) }}">Borrar</a> @endif
                                    @if ($d2>$d1 && ($comision->estado=='aprobada') && $comision->tipocom !='noremunerada' && Auth::user()->cedula == $comision->cedula)
                                    <a href="{{ url('subircumplido', $comision->comisionid) }}">Subir cumplido</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $comisiones->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection