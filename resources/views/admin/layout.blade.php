<!DOCTYPE html>
<html lang="en">

<head>

  <title>{{ config('app.name') }}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  @stack('styles')
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">


</head>

<body class="app sidebar-mini rtl">
  @if (Auth::guard('profesor')->check() && 
        Request::path() != 'recuperacontrasena' && 
        Request::path() != 'recuperausuario'
  && Request::path() != 'login' )
  
    @include('admin.header')
    @include('admin.aside') 
  
  @endif 
  
  @yield('contenido')


  <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>

  @stack('scripts')
  
  <script>
    $( () => {
      $('label').css({'font-weight': 'bold', 'font-size': '18px'})
      console.log();
    });
  </script>
</body>

</html>