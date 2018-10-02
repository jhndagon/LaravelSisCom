@extends('admin.layout')

@section('contenido')

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item">{{ 'PONER CADA COLOR DE LAS COMISIONES' }}</li>

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
                            <td><a href="{{ url('comision', $comision->comisionid) }}">{{$comision->comisionid}}</a></td>
                                <td>{{$comision->radicacion}}</td>
                                <td>{{$comision->actualizacion}}</td>
                                <td>{{$comision->fechaini}}<br>{{ $comision->fechafin}}</td>
                                <td>{{$comision->estado}}</td>
                                <td>{{$comision->institutoid}}</td>
                                <td>{{Auth::user()->nombre}}</td>
                                <td>{{'DESCARGAS'}}</td>
                                <td>{{'ACCIONES'}}</td> 
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