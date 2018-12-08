@extends('admin.layout') 
@section('contenido')
<main class="app-content">
    <div class="row">
        <div class="col">
            <div class="tile">
            <form class="form-horizontal" method="POST" action="{{ url('/profesor') }}">
                    @csrf
                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tipoid">Tipo Identificacion:</label>
                        <div class="col-md-5">
                            <select id="tipoid" name="tipoid" class="form-control">
                                  <option value="cedula" {{isset($profesor) && $profesor->tipoid=='cedula'?'selected':''}}>Cedula</option>
                                  <option value="extranjeria" {{isset($profesor) && $profesor->tipoid=='extranjeria'?'selected':''}}>Extranjeria</option>
                                  <option value="pasaporte" {{isset($profesor) && $profesor->tipoid=='pasaporte'?'selected':''}}>Pasaporte</option>
                                </select>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="cedula">Cedula:</label>
                        <div class="col-md-5">
                            <input 
                                id="cedula" 
                                name="cedula" 
                                type="text" 
                                value='{{ isset($profesor) ? $profesor->cedula : '' }}'
                                placeholder="Cedula" 
                                class="form-control input-md"
                                required>
                                <input type="hidden" name="cedulaanterior" value='{{ isset($profesor) ? $profesor->cedula : '' }}'>
                            <span class="help-block">Ingresa el número de cedula</span>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="nombre">Nombre:</label>
                        <div class="col-md-5">
                            <input 
                                id="nombre" 
                                name="nombre" 
                                type="text" 
                                value='{{ isset($profesor) ? $profesor->nombre : '' }}'
                                placeholder="Nombre" 
                                class="form-control input-md" 
                                required>
                            <span class="help-block">Ingresa el nombre del empleado</span>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">Email:</label>
                        <div class="col-md-5">
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                value='{{ isset($profesor) ? $profesor->email : '' }}'
                                placeholder="Email" 
                                class="form-control input-md" 
                                required>
                                
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <span  role="alert">
                                <strong>{{ $errors->first() }}</strong>
                            </span>
                        </div>
                        @endif
                    </div>

                    @if(Session::get('jefe')==2)
                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tipo">Tipo de contrato:</label>
                        <div class="col-md-5">
                            <select id="tipo" name="tipo" class="form-control">
                                  @foreach ($tipos as $tipo)
                                      <option value='{{$tipo->tipo}}'>{{$tipo->tipo}}</option>
                                  @endforeach
                                </select>
                        </div>
                    </div>

                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="instituto">Instituto:</label>
                        <div class="col-md-5">
                            <select id="instituto" name="instituto" class="form-control">
                                @foreach ($institutos as $instituto)
                                @if (isset($profesor))                                    
                                    <option value='{{$instituto->institutoid}}' {{ strcmp($profesor->institutoid, $instituto->institutoid)==0 ? 'selected':'' }}>{{$instituto->institutoid}}</option>
                                @else
                                    <option value='{{$instituto->institutoid}}'>{{$instituto->institutoid}}</option>
                                
                                @endif
                                    
                                @endforeach
                                </select>
                        </div>
                        
                    </div>
                    
                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="dedicacion">Dedicación exclusiva:</label>
                        <div class="col-md-4">
                            <select id="dedicacion" name="dedicacion" class="form-control">
                                @if (isset($profesor))
                                <option value="Si" {{ $profesor->dedicacion=='Si'?'selected':'' }}>Si</option>
                                <option value="No" {{ $profesor->dedicacion=='No'?'selected':'' }}>No</option>
                                    
                                @else
                                <option value="Si" selected>Si</option>
                                <option value="No">No</option>
                                    
                                    
                                @endif
                                </select>
                        </div>
                    </div>
                    @endif
                    <br>
                    <br>
                    <br>
                    <!-- Button (Double) -->
                    <div class="form-group">
                        <div class="col-md-8">
                            {{-- Esto para indicar si se tiene que crear un profesor --}}
                    @if (isset($profesor))
                        <button id="actualizar" name="actualizar" class="btn btn-success">Actualizar</button>
                        <input type="hidden" name="actualiza" value="actualizar">
                    @else
                        <button id="actualizar" name="actualizar" class="btn btn-success">Registrar</button>
                        <input type="hidden" name="actualiza" value="registrar">
                    @endif
                            <a id="cancelar" name="cancelar" class="btn btn-danger" href="{{ url('/profesores') }}">Cancelar</a>
                        </div>
                    </div>

                    

                </form>

            </div>
        </div>
    </div>

</main>
@endsection

