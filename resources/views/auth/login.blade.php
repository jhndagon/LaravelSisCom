@extends('admin.layout') 
@section('contenido')

<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1><a href="{{url('inicio')}}" class='text-dark text-center'> <p>Sistema de Comisiones,</p> <p>Facultad de Ciencias Exactas y Naturales,</p> <p>Universidad de Antioquia.</p></a></h1>
        
    </div>
    <div class="login-box">
        <form method="POST" action="{{ url('login') }}" class="login-form" style="position: inherit;">
            @csrf
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Ingreso al sistema</h3>
            <div class="form-group">
                <label for="cedula" class="control-label">Cédula</label>
                <input id="cedula" type="text" class="form-control{{ $errors->has('cedula') ? ' is-invalid' : '' }}" name="cedula" value="{{ old('cedula') }}"
                    placeholder="Cédula" required autofocus> @if ($errors->has('cedula'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('cedula') }}</strong>
                    </span> @endif
            </div>

            <div class="form-group">
                <label for="contraseña" class="control-label">{{ __('Contraseña') }}</label>
                <input id="contraseña" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                    placeholder="Contraseña" required> @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span> @endif
            </div>

            <div class="form-group">
                <p class="semibold-text mb-2">
                    <a href="{{ url('recuperacontrasena') }}" data-toggle="flip">                        
                        Recuperar contraseña
                    </a>
                </p>
                <p class="semibold-text mb-2">
                    <a href="{{ url('recuperausuario') }}" data-toggle="flip">                        
                        Recuperar usuario
                    </a>
                </p>
            </div>
            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Ingresar') }}
                </button>
            </div>
        </form>
    </div>
    
        <div class="row">
                <div class="col-md-1"></div>
            <div class="col-md-12">
                    <h2><a href="" class='text-dark text-center'> “Para usar la versión 1 vaya a este enlace (la versión 1 se descontinuará a partir de Febrero 1 de 2019”</a></h2>
            </div>
        </div>

    
@endsection