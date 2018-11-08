@extends('admin.layout')

@section('contenido')
   
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
      <div class="logo">
          <h1>{{ config('app.name') }}</h1>
      </div>
      <div class="login-box pb-3">
        <form method="POST" action="{{ route('recuperacontrasena') }}" class="login-form">
                @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Recupera usuario</h3>

            <div class="form-group">
                <label for="cedula" class="control-label">Ingrese su correo institucional:</label>
                <input
                id="correo"
                  type="email"
                  class="form-control{{ $errors->has('correo') ? ' is-invalid' : '' }}"
                  name="correo"
                  value="{{ old('correo') }}"
                  placeholder="Correo electronico"
                  required
                  autofocus>
                  @if ($errors->has('correo'))
                  <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('correo') }}</strong>
                      </span>
                  @endif
              </div>
        
                
                <div class="form-group">
                <p class="semibold-text mb-2">
                    <a href="{{ url('recuperacontrasena') }}" data-toggle="flip">
                        {{-- <a class="btn btn-link" href=""> --}}
                        Recuperar contraseña
                    </a>
                </p>
                <p class="semibold-text mb-2">
                    <a href="{{ url('recuperausuario') }}" data-toggle="flip">
                        <!-- <a class="btn btn-link" href=""> -->
                        Recuperar usuario
                    </a>
                </p>
            </div>
            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Enviar') }}
                </button>
            </div>
        </form>
    </div>
@endsection