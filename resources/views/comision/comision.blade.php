@extends('admin.layout')

@section('contenido')

<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item">{{ 'PENDIENTE' }}</li>

        </ul>
    </div>
    <div class="row">
        <div class="col">
            @if ($comision)            
                {{ $comision[0] }}
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Essential javascripts for application to work-->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
@endpush
@push('styles')    
    <link rel="stylesheet" type="text/css" href="../css/main.css">    
@endpush