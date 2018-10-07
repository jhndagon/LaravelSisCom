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
                        {{ $comision[0] }}
                    <form>
                        <div class="col-md-6  text-center">
                            <h3>
                                Información de la solicitud
                            </h3>
                            <br>
                        </div>
                        <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Identificación de la comisión: </label>
                                    <div class="col-xs-2">
                                            <input type="text" class="form-control" value="{{ $comision[0]->comisionid }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Fecha de radicación: </label>
                                        <div class="col-xs-2">
                                        <input type="text" class="form-control" value="{{ $comision[0]->radicacion }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            <br>
                        <br>
                        <hr class="my-4">                  

                        <div class="col-md-6  text-center">
                            <h3>
                                Información de la comisón
                            </h3>
                            <br>
                        </div>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-md-2 col-form-label">Tipo de comisión: </label>
                                <div class="col-md-6">
                                        <select class="custom-select" name="tipoComision">
                                            <option selected>Comisión de servicio</option>
                                            <option>Comisión de calamidad</option>
                                        </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Lugar de la comisión: </label>
                                    <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="Lugar de la comisión" value="{{ $comision[0]->lugar }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Fecha de la comisión: </label>
                                    <div class="col-md-6">
                                        <label for="identificador" class="col-md-4 col-form-label">Fecha de inicio: </label>
                                            <input type="date" class="form-control">
                                            <label for="identificador" class="col-md-4 col-form-label">Fecha de Fin: </label>
                                            <input type="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Motivo de la comisión: </label>
                                    <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="Motivo de la comisión" value="{{ $comision[0]->actividad }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Justificación: </label>
                                    <div class="col-md-6">
                                            <textarea type="textarea" class="form-control" rows="4" value="{{ $comision[0]->lugar }}"></textarea>  
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Anexo 1: </label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file" name="anexo1" > 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Anexo 2: </label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file" name="anexo1" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Anexo 3: </label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file" name="anexo1" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="" class="btn btn-primary btn-block">Borrar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ url('inicio') }}" class="btn btn-primary btn-block">Cancelar</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</main>
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