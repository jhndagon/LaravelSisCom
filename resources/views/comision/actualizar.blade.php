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
                    {{-- {{ $comision[0] }} --}}
                    
                    <form action="{{ url('comision', $comision[0]->comisionid)  }}" id="form1" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" value="{{ $comision[0]->comisionid }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Fecha de radicación: </label>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" value="{{ $comision[0]->radicacion }}" readonly>
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
                        @if ($comision[0]->respuesta)
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="respuesta" class="col-md-2 col-form-label">Respuesta: </label>
                                    <div class="col-md-6">
                                        {{ $comision[0]->respuesta }}
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
                                        <input type="text" class="form-control" name='lugar' placeholder="Lugar de la comisión" value="{{ $comision[0]->lugar }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="fecharango" class="col-sm-2 col-form-label">Fecha de la comisión: </label>
                                    <div class="col-sm-6">
                                        <input type="text" id="fecharango" name="fecharango" class="form-control" value="{{$comision[0]->fecha}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Motivo de la comisión: </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="actividad" placeholder="Motivo de la comisión" value="{{ $comision[0]->actividad }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Idioma de la comisión: </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="idioma" placeholder="Idioma de la comisión" value="{{ $comision[0]->idioma }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-2 col-form-label">Justificación: </label>
                                    <div class="col-md-6">
                                        <textarea type="textarea" class="form-control" rows="4" name="justificacion">{{ $comision[0]->justificacion }}</textarea>
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
                            @if (Session::get('jefe') == 1 || Session::get('jefe') == 2)

                            <div class="form-group">
                                <h2>Reservado para la administración</h2>
                                <div class="form-group row">
                                    <label for="vistobueno" class="col-md-2 col-form-label">Devolución: </label>
                                    <div class="col-md-3">
                                        <select class="custom-select" name="devolucion">
                                                    <option value="No" {{ $comision[0]->estado!='devuelta'  ? 'selected':''}}>No</option>
                                                    <option value="Si" {{ $comision[0]->estado=='devuelta'  ? 'selected':''}}>Si</option>
                                                </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="vistobueno" class="col-md-2 col-form-label">Visto bueno del director: </label>
                                    <div class="col-md-3">
                                        <select class="custom-select" name="vistobueno">
                                                <option value="No" {{ $comision[0]->vistobueno=='No'  ? 'selected':''}}>No</option>
                                                <option value="Si" {{ $comision[0]->vistobueno=='Si'  ? 'selected':''}}>Si</option>
                                            </select>
                                    </div>
                                </div>
                            </div>

                            @if(Session::get('jefe') == 2)
                            <div class="form-group row">
                                <label for="aprobacion" class="col-md-2 col-form-label">Aprobacion decan@: </label>
                                <div class="col-md-3">
                                    <select class="custom-select" name="aprobacion">
                                                <option value="No" {{ $comision[0]->aprobacion=='No'  ? 'selected':''}}>No</option>
                                                <option Value="Si" {{ $comision[0]->aprobacion=='Si'  ? 'selected':''}} >Si</option>
                                            </select>
                                </div>
                            </div>
                            @endif



                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="respuesta" class="col-md-2 col-form-label">Respuesta: </label>
                                    <div class="col-md-6">
                                    <textarea type="textarea" class="form-control" name="respuesta" rows="4">{{ $comision[0]->respuesta ? $comision[0]->respuesta : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                <div class="form-group row">
                                    @if ($comision[0]->vistobueno == 'No' || $comision[0]->aprobacion == 'No' )
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
<script>
    $(document).ready(function(){
    $('#devolucion').click()
});

</script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    var vistobueno = '{{$comision[0]->vistobueno}}';
    var aprobacion = '{{$comision[0]->aprobacion}}';
    var jefe = '{{Session::get("jefe")}}';
    if(jefe > 0 || vistobueno == 'Si' || aprobacion == 'Si'){
        var inputs = document.getElementsByTagName("input");
        for (let index = 0; index < inputs.length; index++) {
            inputs[index].readOnly = true;
            
        console.log(inputs[index].value);
        }
    }
</script>

<script>
    $("#fecharango").daterangepicker({            
            "locale": {
                "language": "es",
                "format": "DD MMMM YYYY",
                "separator": " a ",
                "applyLabel": "Aceptar",
                "cancelLabel": "Cancelar",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNamesShort": ['Ene','Feb','Mar','Abr','May','Jun',
                                  'Jul','Ago','Sep','Oct','Nov','Dic'],
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
        datepickerOptions: {
                minDate: 0,
                maxDate: null,
                lenguage: "es"
            },
        applyOnMenuSelect: false,
        initialText : 'Seleccione el rango de fechas...',
        applyButtonText : 'Escoger',
        clearButtonText : 'Limpiar',
        cancelButtonText : 'Cancelar',
        });
        $("#fecharango").datepicker({
        format: "DD MMMM YYYY",
        todayBtn: true,
        clearBtn: true,
        language: "es"
    });
        // var today = moment().toDate();
        // var tomorrow = moment().add('days', 1).startOf('day').toDate();
        // $("#fecharango").daterangepicker({
        //     onOpen: $("#fecharango").daterangepicker("setRange",{start: today,end: tomorrow})
        // });

</script>



@endpush