@extends('admin.layout') 
@section('contenido')
<main class="app-content">

    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item">{{ 'PONER CADA COLOR DE LAS COMISIONES' }}</li>

        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                <form action="{{ url('/informes') }}" method="POST">
                    @csrf
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opciones" value="todas" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                      Mostrar todas las comisiones hasta la fecha.
                                    </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opciones" value="permisos">
                            <label class="form-check-label" for="exampleRadios3">
                                Mostrar todos los permisos.<br/>
                                {{-- <pre>
                                    * from Comisiones where (tipocom='noremunerada' and tipocom='calamidad')
                                </pre>
                            </td> --}}
                        </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opciones" value="cedula">
                            <label class="form-check-label" for="exampleRadios2">
                                Mostrar las comisiones presentadas por la cedula.
                            </label>
                        </div>
                        <br>
                        <div class="form-group row {{ $errors->any()?'has-error':''  }}" >
                            <label for="busqueda" class="col-sm-1 col-form-label">Buscar: </label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" name="busqueda" placeholder="Información a buscar">
                            </div>
                            @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('busqueda') }}
                            </div>
                            @endif
                        </div>


                        <button type="submit">Buscar</button>
                    </form>

                    @if (isset($comisiones))
                        @foreach ($comisiones as $comision)
                            {{$comision}}
                        @endforeach
                        
                    @endif

                

                </div>
            </div>
        </div>
    </div>
</main>
@endsection