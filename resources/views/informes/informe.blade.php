@extends('admin.layout') 
@section('contenido')
<main class="app-content">

    <div class="app-title">

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                <form action="{{ url('/informes') }}" method="POST">
                    @csrf
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opciones" value="todas" {{ !isset($sebusco)?'checked':$sebusco['opcion']=='todas'?'checked':'' }}>
                            <label class="form-check-label" for="exampleRadios1">
                                      Mostrar todas las comisiones hasta la fecha.
                                    </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opciones" value="cedula" {{ isset($sebusco)&&$sebusco['opcion']=='cedula'?'checked':'' }}>
                            <label class="form-check-label" for="exampleRadios2">
                                Mostrar las comisiones presentadas por la cedula.
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opciones" id="fecha" value="fecha" {{ isset($sebusco)&&$sebusco['opcion']=='fecha'?'checked':'' }}>
                            <label class="form-check-label" for="exampleRadios2">
                                Mostrar las comisiones en la(s) fecha(s):
                            </label>
                        </div>            
                            
                        </div>
                        <br>
                        <div class="form-group d-none" id="fechas">
                            <div class="form-group row">
                                <label for="fecharango" class="col-sm-1">Fechas:</label>
                                <div class="col">
                                    <input type="text" id="fecharango" name="fecharango" class="form-control">
                                </div>
                            </div>
                        </div>

                       <div class="form-group row">
                            <div class="col-md-4">                        
                                <label class="control-label" for="checkboxes">Seleccione el tipo de comision: </label>
                            </div>
                            <div class="col-md-3">
                                @foreach ($tipocom as $tipo)
                        
                                <div class="checkbox">
                                    <label for="checkboxes-0">
                                    <input type="checkbox" name="tipocom[]" value="{{$tipo->tipocom}}">
                                    {{$tipo->tipocom}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                        
                                <label class="control-label" for="checkboxes">Seleccione los institutos que desea incluir en la consulta: </label>
                            </div>
                            <div class="col-md-3">
                                @foreach ($institutos as $instituto)
                        
                                <div class="checkbox">
                                    <label for="checkboxes-0">
                                        <input type="checkbox" name="institutos[]" value="{{$instituto->institutoid}}">
                                        {{$instituto->instituto}}
                                        </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                              
                        
                        <div class="form-group row {{ $errors->any()?'has-error':''  }}" >
                            <label for="busqueda" class="col-sm-1 col-form-label">Buscar: </label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" name="busqueda" placeholder="Información a buscar" value={{ isset($sebusco)?$sebusco["busqueda"]:''}}>
                            </div>
                            @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('busqueda') }}
                            </div>
                            @endif
                        </div>


                        <button type="submit" id="enviar" class="btn btn-primary">Buscar</button>
                    </form>

                    @if (isset($esquema))
                    <br>
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">                                

                                    <a class="btn btn-primary" href="{{ url('/descargarinforme', ['info'=>json_encode($sebusco)]) }}">Generar informe </a>
                                
                            </li>
                        </ul>
                        <br>
                        <div class="row">
                            <div class="col-md-3">Total encontradas: {{ count($comisiones) }}</div>
                        </div>
                        <br>
                    @endif
                    <br>
                    <div class="table-responsive">
                    <table class="table">
                            <thead>
                              <tr>
                                  @if (isset($esquema))
                                    @foreach ($esquema as $key=>$valor)
                                        <th scope="col">
                                            {{$valor}}
                                        </th>                   
                                        @if($key>10)
                                            @break
                                        @endif   
                                        @if ($valor == 'cedula')
                                        <td scope="col">                                            
                                            Nombre                    
                                        </td>
                                        @endif                      
                                    @endforeach                          
                                    
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($comisiones))               
                                @foreach ($comisiones as $comision)
                                    <tr>             
                                        @foreach ($esquema as $key=>$valor)
                                            <td>                                            
                                                {{$comision[$valor]}}                    
                                            </td>                       
                                            @if($key>10)
                                                @break
                                            @endif 
                                            @if ($valor == 'cedula')
                                            <td>                                            
                                                {{ $comision->profesor['nombre']}}             
                                            </td>
                                            @endif
                                        @endforeach
                                    </tr>                                              
                                @endforeach
                            @endif                               
                                
                            </tbody>
                            @endif
                          </table>
                        </div>
                

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
                    "format": "YYYY-MM-D",
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
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Hoy': [moment(), moment()],
                    'Este mes': [moment().add('month', 0).startOf('month'), moment().add('month', 0).endOf('month')],
                    'Mes pasado': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
                    'Año pasado': [moment().subtract('year', 1).startOf('year'), moment().subtract('year', 1).endOf('year')],
                    'Este año': [moment().add('year', 0).startOf('year'), moment().add('year', 0).endOf('year')]
                }
            },

        );
    });
</script>

<script>
    let flag = false;
$(() => {
    //$("#fechas").hide()
    $('#enviar').click( () => {
        if($('#fecha').is(':checked')){
            // alert('Desa enviar la info')
        }
    });
    $("#fecha").click(()=> {
        if(flag){
            $("#fechas").removeClass('d-none');
            
        }
        
    });
    $('input:radio[name="opciones"]').click(()=> {
        let checked = $('input:radio[name="opciones"]:checked').val();
        if(checked == 'fecha'){
            $("#fechas").removeClass('d-none');
        }else{
            $("#fechas").addClass('d-none');
        }
    });
});
</script>

@endpush

@push('styles')   
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush