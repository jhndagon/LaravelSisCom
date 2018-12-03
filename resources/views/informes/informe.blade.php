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
                            <input class="form-check-input" type="radio" name="opciones" value="todas" {{ !isset($sebusco)?'checked':$sebusco['opcion']=='todas'?'checked':'' }}>
                            <label class="form-check-label" for="exampleRadios1">
                                      Mostrar todas las comisiones hasta la fecha.
                                    </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opciones" value="permisos" {{ isset($sebusco)&&$sebusco['opcion']=='permisos'?'checked':'' }}>
                            <label class="form-check-label" for="exampleRadios3">
                                Mostrar todos los permisos.<br/>
                                {{-- <pre>
                                    * from Comisiones where (tipocom='noremunerada' and tipocom='calamidad')
                                </pre>
                            </td> --}}
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
                        <div class="form-group" id="fechas">
                            <div class="form-group row">
                                <label for="fecharango" class="col-sm-1">Fechas:</label>
                                <div class="col-sm-3">
                                    <input type="text" id="fecharango" name="fecharango" class="form-control">
                                </div>
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
                                <a class="btn btn-primary" href="{{ url('') }}}">Generar informe </a>
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

<script>
$(() => {
    //$("#fechas").hide()
    $('#enviar').click( () => {
        if($('#fecha').is(':checked')){
            alert('Desa enviar la info')
        }
    });
    $("#fecha").click(()=> {
        //$("#fechas").show()
        console.log('Algo');
    });
});
</script>

@endpush