@extends('admin.layout')

@section('contenido')

<main class="app-content">
    <div class="app-title">
        <div>
        <h1><i class="fa fa-th-list"></i> Data Table</h1>
        <p>Table to display analytical data effectively</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
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
                                <td>{{$comision->comisionid}}</td>
                                <td>{{$comision->radicacion}}</td>
                                <td>{{$comision->actualizacion}}</td>
                                <td>{{'FECHAS'}}</td>
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