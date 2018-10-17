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
                                <label for="fechaActualizacion" class="col-sm-2 col-form-label">Fecha de actualización: </label>
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
                                        <select class="custom-select" name="tipocom">
                                            <option selected value="servicios">Comisión de servicio</option>
                                            <option value="estudio">Comisión de estudios</option>
                                            <option value="noremunerada">Permiso</option>
                                            <option value="calamidad">Calamidad</option>
                                        </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="lugar" class="col-sm-2 col-form-label">Lugar de la comisión: </label>
                                    <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Lugar de la comisión" name="lugar">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="fecharango" class="col-sm-2 col-form-label">Fecha de la comisión: </label>
                                    <div class="col-sm-6">
                                        <input id="fecharango" name="fecharango" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="actividad" class="col-sm-2 col-form-label">Motivo de la comisión: </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Motivo de la comisión" name="actividad">
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Idioma de la comisión: </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" placeholder="Idioma de la comisión" name="idioma">
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Justificación: </label>
                                    <div class="col-sm-6">
                                            <textarea type="textarea" class="form-control" rows="4" name="justificacion"></textarea>  
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Anexo 1: </label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control-file" name="anexo1" > 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Anexo 2: </label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control-file" name="anexo2" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Anexo 3: </label>
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

    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>

        $("#fecharango").daterangepicker({
            timeZone: 'utc-5',
            "locale": {
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
        // datepickerOptions: {
        //         minDate: 0,
        //         maxDate: null
        //     },
        // applyOnMenuSelect: false,
        // initialText : 'Seleccione el rango de fechas...',
        // applyButtonText : 'Escoger',
        // clearButtonText : 'Limpiar',
        // cancelButtonText : 'Cancelar',
        });
        // jQuery(function($){
        //     $.datepicker.regional['es'] = {
        //         closeText: 'Cerrar',
        //         prevText: '&#x3c;Ant',
        //         nextText: 'Sig&#x3e;',
        //         currentText: 'Hoy',
        //         monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
        //                      'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        //         monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
        //                           'Jul','Ago','Sep','Oct','Nov','Dic'],
        //         dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        //         dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
        //         dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        //         weekHeader: 'Sm',
        //         dateFormat: 'dd/mm/yy',
        //         firstDay: 1,
        //         isRTL: false,
        //         showMonthAfterYear: false,
        //         yearSuffix: ''};
        //     $.datepicker.setDefaults($.datepicker.regional['es']);
        // });

        // var today = moment().toDate();
        // var tomorrow = moment().add('days', 1).startOf('day').toDate();
        // $("#fecharango").daterangepicker({
        //     onOpen: $("#fecharango").daterangepicker("setRange",{start: today,end: tomorrow})
        // });

        </script>

@endpush
@push('styles')    
    <link rel="stylesheet" type="text/css" href="../css/main.css">    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush