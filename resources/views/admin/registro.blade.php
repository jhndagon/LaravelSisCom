<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - {{ config('app.name')}}</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>{{ config('app.name') }}</h1>
      </div>
      <div class="login-box">
        <form method="POST" action="{{ route('registrar') }}" class="login-form">
            @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Ingreso al sistema</h3>
            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input
                id="email"
                type="email"
                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                name="email"
                value="{{ old('email') }}"
                placeholder="email"
                required
                autofocus>
            </div>

            <div class="form-group">
                <label for="contraseña" class="control-label">{{ __('Contraseña') }}</label>
                <input
                id="contraseña"
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="password"
                placeholder="contraseña"
                required>
            </div>
            <div class="form-group">
                <label for="usuario" class="control-label">{{ __('Usuario') }}</label>
                <input
                id="usuario"
                type="text"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="usuario"
                placeholder="usuario"
                required>
            </div>
            <div class="form-group">
                <label for="cedula" class="control-label">{{ __('cedula') }}</label>
                <input
                id="cedula"
                type="text"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="cedula"
                placeholder="cedula"
                required>
            </div>

            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Registrar') }}
                </button>
            </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>










