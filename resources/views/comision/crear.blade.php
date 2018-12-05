@extends('admin.layout')

@section('contenido')
<main class="app-content">
    <div class="app-title">
        
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6  text-center">
                            <h3>
                                Información de la solicitud
                            </h3>
                            <br>
                        </div>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="comisionid" class="col-sm-2 col-form-label">Identificación de la comisión: </label>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" value="{{ $random }}" name="comisionid" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="fechaRadicacion" class="col-sm-2 col-form-label">Fecha de radicación: </label>
                                <div class="col-xs-2">
                                        <input type="text" class="form-control"  value="{{ $fechaActual }}" name="fecharadicacion" readonly>
                                </div>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="fechaactualizacion" class="col-sm-2 col-form-label">Fecha de actualización: </label>
                                <div class="col-xs-2">
                                        <input type="text" class="form-control"  value="{{ $fechaActual }}" name="fechaactualizacion" readonly>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <hr class="my-4">                  

                        <div class="col-md-6  text-center">
                            <h3>
                                Información de la comisón
                            </h3>
                            <br>
                        </div>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="tipocom" class="col-sm-2 col-form-label">Tipo de comisión: </label>
                                <div class="col-sm-6">
                                        <select class="custom-select" name="tipocom" id="tipocom">
                                            <option value="servicios" {{old('tipocom')=='servicios'?'selected':''}}>Comisión de servicio</option>
                                            <option value="estudio" {{old('tipocom')=='estudio'?'selected':''}}>Comisión de estudios</option>
                                            <option value="noremunerada" {{old('tipocom')=='noremunerada'?'selected':''}}>Permiso</option>
                                            <option value="calamidad" {{old('tipocom')=='calamidad'?'selected':''}}>Calamidad</option>
                                        </select>
                                </div>
                            </div>
                            <div class="form-group disponibles d-none">
                                <div class="form-group row">
                                    <label for="lugar" class="col-sm-2 col-form-label " >Días disponibles: </label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="diaspermiso" value="{{ Auth::user()->extra1 }}"readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="lugar" class="col-sm-2 col-form-label" >Lugar de la comisión: </label>
                                    <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Lugar de la comisión" name="lugar" value="{{ old('lugar')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="fecharango" class="col-sm-2 col-form-label" >Fecha de la comisión: </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="fecharango" name="fecharango" class="form-control  {{$errors->any()?'is-invalid':''}}">
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
                                    <label for="actividad" class="col-sm-2 col-form-label">Motivo de la comisión: </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Motivo de la comisión" name="actividad" value="{{ old('actividad')}}" required>
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="idioma" class="col-sm-2 col-form-label">Idioma de la comisión: </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Idioma de la comisión" name="idioma" value="{{ old('idioma')}}" required>
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="justificacion" class="col-sm-2 col-form-label">Justificación: </label>
                                    <div class="col-sm-6">
                                            <textarea type="textarea" class="form-control" rows="4" name="justificacion">{{ old('justificacion') }}</textarea>  
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="anexo1" class="col-sm-2 col-form-label">Anexo 1: </label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control-file" name="anexo1" > 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="anexo2" class="col-sm-2 col-form-label">Anexo 2: </label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control-file" name="anexo2" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="anexo3" class="col-sm-2 col-form-label">Anexo 3: </label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control-file" name="anexo3" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ url('comision') }}" class="btn btn-primary btn-block">Borrar</a>
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


<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(function() {

        $('input[name="fecharango"]').daterangepicker({
                opens: 'left',
                startDate: '' || moment(), //para cuando se necesite actualizar una comision
                endDate: '' || moment(), //para cuando se necesite actualizar una comision
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


$(document).on('change', '#tipocom', () =>{
    let tipocom = $('#tipocom option:selected').val();
    if(tipocom !== 'noremunerada' && tipocom !== 'calamidad' ){
        $('.disponibles').addClass('d-none');
        console.log('añadi clase');
    }else{
        $('.disponibles').removeClass('d-none');
    }
})

</script>




@endpush
@push('styles')   
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush