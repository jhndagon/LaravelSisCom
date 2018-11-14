@extends('admin.layout') 
@section('contenido')
<main class="app-content">


    <nav class="app-title navbar navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="btn btn-outline-secundary" href="{{ url('/profesor', ['id'=>0]) }}}">Agregar empleado </a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="{{ url('/profesor') }}">
            @csrf
            <input class="form-control mr-sm-2" placeholder="Buscar empleado" name="buscar">
            <div class="input-group mb-6">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="">Opciones</label>
                    </div>
                    <select class="custom-select" name="opcion">
                      {{-- <option selected value='nombre'>Nombre</option> no funciona porque los nombres en la base de datos estan en mayúscula--}}
                      <option value="institutoid">Instituto</option>
                      <option value="cedula">Cedula</option>
                      <option value="email">Correo</option>
                    </select>
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
                            <th>Instituto</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profesores as $profesor)
                        <tr>
                            <td>{{ $profesor->cedula}}</td>
                            <td>{{ $profesor->nombre}}</td>
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