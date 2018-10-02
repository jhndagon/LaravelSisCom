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

		
	</head>
  <body class="app sidebar-mini rtl">
    @if (Auth::guard('profesor')->check())
			@include('admin.header')
			@include('admin.aside')				
		@endif

    @yield('contenido')


		@stack('scripts')
	
  </body>
</html>