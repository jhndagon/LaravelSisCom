@extends('admin.layout') 
@section('contenido')
<main class="app-content">
    <div class="app-title">

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