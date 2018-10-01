@extends('admin.layout')

@section('contenido')
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                   {{ $comision }}
                </div>
            </div>
        </div>
    </div>
</main>       
@endsection