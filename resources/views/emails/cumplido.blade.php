<p>
        Apreciado(a) ,
        
        <p>
        El(La) Empleado(a) <b>{{$nombre}}</b> identificado con
        documento <b>{{ $comision->profesor->cedula }}</b> de <b>{{ $comision->institutoid }}</b>, ha concluido
        una comision de <b>{{$comision->tipocom}}</b> con el objetivo de <b>{{ $comision->actividad }}</b>.  La
        actividad se realizó en la(s) fecha(s) <b>{{$comision->fecha}}</b>.
        </p>
        
        <p>
        Como parte de los compromisos con su dependencia
        el profesor ha subido al <b>Sistema de Comisiones de la Facultad</b>,
        el(los) siguiente(s) documento(s) que certifican la realización de la
        actividad realizada (cumplidos).
        </p>
        
        <p>
        Usted puede descargar el(los) documento(s) de los siguientes enlaces:
        </p>
        
        @if($comision->cumplido1)
        <a target="_black" href="{{url('/documentoscumplido/'. $comision->comisionid . '/Cumplido1_'.$comision->cedula.'_'.$comision->comisionid.'_'.$comision->cumplido1)}}">Cumplido 1</a><br>                                    
                                    

        @endif
        @if ($comision->cumplido2)
        <a target="_black" href="{{url('/documentoscumplido/'. $comision->comisionid . '/Cumplido2_'.$comision->cedula.'_'.$comision->comisionid.'_'.$comision->cumplido1)}}">Cumplido 2</a><br>                                    
                                    
         @endif
        
        
        <p>
        La siguiente información de interés fue adicionalmente provista por el
        profesor para su conocimiento:
        <blockquote><i>{{$comision->infocumplido}}</i></blockquote>
        </p>
        
        <p style="color:red">
        Le solicitamos amablemente confirmar la recepción de esta
        documentación haciendo click en este enlace:  
                <a href="{{ url('cumplido', ['comisionid' => $comision->comisionid, 'confirma'=> $envioa]) }}">confirmar recepción de correo</a>
                .
        </p>
        
        <p>Atentamente,</p>
        
        <p>
        <b>Sistema de Solicitud de Comisiones<br/>
        Decanato, FCEN</b>
        </p>