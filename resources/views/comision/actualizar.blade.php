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
                    {{-- {{ $comision }} --}}
                    
                    <form action="{{ url('comision', $comision->comisionid)  }}" id="form1" method="POST" enctype="multipart/form-data">
                        @csrf {{ method_field('PUT') }}
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
                                    <input type="text" class="form-control" value="{{ $comision->comisionid }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Fecha de radicación: </label>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" value="{{ $comision->radicacion }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Fecha de actualización: </label>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" readonly value="{{ $fechaActual }}" name="fechaactualizacion">
                                </div>
                            </div>
                        </div>
                        @if ($comision->respuesta)
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="respuesta" class="col-md-2 col-form-label">Respuesta: </label>
                                    <div class="col-md-6">
                                        {{ $comision->respuesta }}
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                        <select class="custom-select" name="tipocom" id='tipocom'>
                                            <option value="servicios" {{ $comision->tipocom == 'servicios'?'selected':'' }}>Comisión de servicio</option>
                                            <option value="estudio" {{ $comision->tipocom == 'estudio'?'selected':'' }}>Comisión de estudios</option>
                                            <option value="noremunerada" {{ $comision->tipocom == 'noremunerada'?'selected':'' }}>Permiso</option>
                                            <option value="calamidad" {{ $comision->tipocom == 'calamidad   '?'selected':'' }}>Calamidad</option>
                                        </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Lugar de la comisión: </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name='lugar' placeholder="Lugar de la comisión" value="{{ $comision->lugar }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="fecharango" class="col-sm-2 col-form-label">Fecha de la comisión: </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="fecharango" name="fecharango" class="form-control {{$errors->any()?'is-invalid':''}}">
                                    </div>
                                </div>
                                @if($errors->any())
                                <div class="alert alert-dismissible alert-danger">
                                    <p>{{ $errors->first('diaspermiso')}}</p>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Motivo de la comisión: </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="actividad" placeholder="Motivo de la comisión" value="{{ $comision->actividad }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Idioma de la comisión: </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="idioma" placeholder="Idioma de la comisión" value="{{ $comision->idioma }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Justificación: </label>
                                    <div class="col-md-6">
                                        <textarea type="textarea" class="form-control" rows="4" name="justificacion">{{ $comision->justificacion }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="anexo1" class="col-md-2 col-form-label">Anexo 1: </label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file" name="anexo1">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="anexo2" class="col-md-2 col-form-label">Anexo 2: </label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file" name="anexo1">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="anexo3" class="col-md-2 col-form-label">Anexo 3: </label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file" name="anexo1">
                                    </div>
                                </div>
                            </div>
                            @if (Session::get('jefe') > 0 && $comision->estado != 'aprobada')

                            <div class="form-group">
                                <h2>Reservado para la administración</h2>

                                
                                <div class="form-group row">
                                    <label for="vistobueno" class="col-md-2 col-form-label">Devolución: </label>
                                    <div class="col-md-3">
                                        <select class="custom-select" name="devolucion" id='devolucion'>
                                            <option value="No" {{ $comision->estado!='devuelta'  ? 'selected':''}}>No</option>
                                            <option value="Si" {{ $comision->estado=='devuelta'  ? 'selected':''}}>Si</option>
                                        </select>
                                    </div>
                                </div>
                                @if (Session::get('jefe') == 1)
                                    
                                <div class="form-group row">
                                    <label for="vistobueno" class="col-md-2 col-form-label">Visto bueno del director: </label>
                                    <div class="col-md-3">
                                        <select class="custom-select" name="vistobueno">
                                                <option value="No" {{ $comision->vistobueno=='No'  ? 'selected':''}}>No</option>
                                                <option value="Si" {{ $comision->vistobueno=='Si'  ? 'selected':''}}>Si</option>
                                            </select>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if(Session::get('jefe') == 2)
                            <div class="form-group row">
                                <label for="aprobacion" class="col-md-2 col-form-label">Aprobacion decan@: </label>
                                <div class="col-md-3">
                                    <select class="custom-select" name="aprobacion">
                                                <option value="No" {{ $comision->aprobacion=='No'  ? 'selected':''}}>No</option>
                                                <option Value="Si" {{ $comision->aprobacion=='Si'  ? 'selected':''}} >Si</option>
                                            </select>
                                </div>
                            </div>
                            @endif



                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="respuesta" class="col-md-2 col-form-label">Respuesta: </label>
                                    <div class="col-md-6">
                                    <textarea 
                                        type="textarea" 
                                        class="form-control" 
                                        name="respuesta" 
                                        id='respuesta'
                                        rows="4">{{ $comision->respuesta ? $comision->respuesta : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                <div class="form-group row">
                                    @if ($comision->vistobueno == 'No' || $comision->aprobacion == 'No' )
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="" class="btn btn-primary btn-block">Borrar</a>
                                    </div>
                                    @endif
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


<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(function() {

        $('input[name="fecharango"]').daterangepicker({
                opens: 'left',
                startDate: '{{$comision->fechaini}}' || moment(), //para cuando se necesite actualizar una comision
                endDate: '{{$comision->fechafin}}' || moment(), //para cuando se necesite actualizar una comision
                initialText: 'Seleccione el rango de fechas...',
                alwaysShowCalendars: true,
                showCustomRangeLabel: false,
                "locale": {
                    "format": "MMM DD, YYYY",
                    "separator": " a ",
                    "applyLabel": "Aceptar",
                    "cancelLabel": "Cancelar",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Augosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                },
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Mañana': [moment().add(1, 'days'), moment().add(1, 'days')],
                    'Proxima semana': [moment().add('weeks', 1).startOf('week'), moment().add('weeks', 1).endOf('week')],
                }
            },

        );
    });
</script>


@endpush
@push('styles')   
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush