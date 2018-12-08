@extends('admin.layout') 
@section('contenido')
<main class="app-content">


    <nav class="app-title navbar navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="btn btn-primary" href="{{ url('/profesor', ['id'=>0]) }}}">Agregar empleado </a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="{{ url('/profesor') }}">
            @csrf
            <div class="input-group mb-8">
                <label for="opcion">Seleccione una opción de búsqueda:  </label>
                <select class="custom-select" name="opcion">
                    {{-- <option selected value='nombre'>Nombre</option> no funciona porque los nombres en la base de datos estan en mayúscula--}}
                    <option value="nombre" {{ isset($opcion) && $opcion == 'nombre'? 'selected': ''}}>Nombre</option>
                    <option value="institutoid" {{ isset($opcion) &&  $opcion == 'institutoid' ? 'selected': ''}}>Instituto</option>
                    <option value="cedula" {{ isset($opcion) && $opcion == 'cedula'? 'selected': ''}}>Cedula</option>
                    <option value="email" {{ isset($opcion) && $opcion == 'email'? 'selected': ''}}>Correo</option>
                </select>
            </div>
            <div class="input-group mb-6">

                <input class="form-control mr-sm-2" placeholder="Ingrese el valor de la búsqueda" name="buscar">
            </div>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>

    </div>
    <div class="row">
        <div class="col">
            <div class="tile">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Instituto</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profesores as $profesor)
                        <tr>
                            <td>{{ $profesor->cedula}}</td>
                            <td>{{ $profesor->nombre}}</td>
                            <td>{{ $profesor->email}}</td>
                            <td>{{ $profesor->institutoid}}</td>
                            <td>
                                <div class="row">
                                    <div class="col"><a href="{{ url('/profesor', $profesor->cedula) }}">Editar</a></div>
                                    <div class="col"><a href="{{ url('/eliminaprofesor', $profesor->cedula) }}">Eliminar</a></div>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection