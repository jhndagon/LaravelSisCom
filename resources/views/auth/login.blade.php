@extends('admin.layout')

@section('contenido')
    
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
      <div class="logo">
          <h1>{{ config('app.name') }}</h1>
      </div>
      <div class="login-box">
        <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Ingreso al sistema</h3>
          <div class="form-group">
              <label for="cedula" class="control-label">Cédula</label>
              <input
              id="cedula"
                type="text"
                class="form-control{{ $errors->has('cedula') ? ' is-invalid' : '' }}"
                name="cedula"
                value="{{ old('cedula') }}"
                placeholder="Cédula"
                required
                autofocus>
                @if ($errors->has('cedula'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('cedula') }}</strong>
                    </span>
                @endif
            </div>
            
            <div class="form-group">
                <label for="contraseña" class="control-label">{{ __('Contraseña') }}</label>
                <input
                id="contraseña"
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="password"
                placeholder="Contraseña"
                required>
                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group">
                <p class="semibold-text mb-2">
                    <a href="" data-toggle="flip">
                        <!-- <a class="btn btn-link" href=""> -->
                        Recuperar contraseña
                    </a>
                </p>
                <p class="semibold-text mb-2">
                    <a href="" data-toggle="flip">
                        <!-- <a class="btn btn-link" href=""> -->
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
@endsection
    
@push('scripts')
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
@endpush

@push('styles')    
    <link rel="stylesheet" type="text/css" href="css/main.css">    
@endpush   
    
    