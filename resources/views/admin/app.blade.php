@extends('admin.layout')

@section('contenido')

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item">{{ 'PONER CADA COLOR DE LAS COMISIONES' }}</li>
        <table ><tr>
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
            </tr></table>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Comisión</th>
                            <th>Radicación</th>
                            <th>Actualización</th>
                            <th>Fechas</th>
                            <th>Estado</th>
                            <th>Instituto</th>
                            <th>Solicitante</th>
                            <th>Descargas</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                            @foreach ($comisiones as $comision)   
                            <tr>                         
                                <td>
                                    <a href="{{ url('comision', $comision->comisionid) }}">
                                        {{$comision->comisionid}}
                                    </a>
                                </td>
                                <td>{{$comision->radicacion}}</td>
                                <td>{{$comision->actualizacion}}</td>
                                <td>{{$comision->fechaini}}<br>{{ $comision->fechafin}}</td>
                                <td>{{$comision->estado}}</td>
                                <td>{{$comision->institutoid}}</td>
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
                                
                                </td>
                                <td>
                                    @if (!$comision->vistobueno == 'si' && !$comision->aprobacion == 'si' )
                                        <a href="{{ url('eliminarComision', $comision->comisionid) }}">Borrar</a>
                                    @endif    
                                </td> 
                            </tr>                           
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>            



@endsection


@push('scripts')
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
@endpush

@push('styles')    
    <link rel="stylesheet" type="text/css" href="css/main.css">    
@endpush