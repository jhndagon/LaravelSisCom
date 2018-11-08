@extends('admin.layout') 
@section('contenido')
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item">{{ 'PONER CADA COLOR DE LAS COMISIONES' }}</li>
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
                <form class="form-horizontal" method="POST" action="{{ route('modificarcontrasena') }}">
                    @csrf
                    <fieldset>
                        <!-- Form Name -->
                        <legend>Modificar Contraseña</legend>
                        
                        @if ($errors->any())
                            @foreach($errors->all() as $error )
                                <div class="alert alert-danger" role="alert">
                                    <p>{{ $error }}</p>
                                </div>
                            @endforeach
                        @endif

                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-8 control-label" for="contrasenanueva">Contraseña nueva</label>
                            <div class="col-md-8">
                                <input id="contrasenanueva" name="contrasenanueva" type="password" placeholder="Contraseña nueva" class="form-control input-md"
                                    required="">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-8 control-label" for="repetircontrasena">Repetir contraseña</label>
                            <div class="col-md-8">
                                <input id="repetircontrasena" name="repetircontrasena" type="password" placeholder="Repetir contraseña" class="form-control input-md"
                                    required="">

                            </div>
                        </div>

                        <!-- Button (Double) -->
                        <div class="form-group">
                            <label class="col-md-8 control-label" for="enviar"></label>
                            <div class="col-md-8">
                                <button id="enviar" name="enviar" class="btn btn-success">Enviar</button>
                                <a id="cancelar" href="{{ url('inicio') }}" name="cancelar" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>

                    </fieldset>
                </form>

            </div>

        </div>
    </div>
</main>
@endsection