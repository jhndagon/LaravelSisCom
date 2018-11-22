<?php
$DESTINATARIOS_CUMPLIDOS = array(
        array("Secretaria del Decanato", "Luz Mary Castro", "luz.castro@udea.edu.co"),
        array("Secretaria del CIEN", "Ana Catalina Fernández", "ana.fernandez@udea.edu.co"),
        array("Programa de Extensión", "Natalia López", "njlopez76@gmail.com"),
        array("Fondo de Pasajes Internacionales", "Mauricio Toro", "fondosinvestigacion@udea.edu.co"),
        array("Vicerrectoria de Investigación", "Mauricio Toro", "tramitesinvestigacion@udea.edu.co"),
        array("Centro de Investigaciones SIU", "Ana Eugenia", "aeugenia.restrepo@udea.edu.co"),
        array("Fondos de Vicerrectoría de Docencia", "Sandra Monsalve", "programacionacademica@udea.edu.co"),
    );
?>


    
@extends('admin.layout') 
@section('contenido')

    <main class="app-content">
        <div class="row">
            <div class="col-md-12">

                <div class="tile">
                    <div class="tile-body">
                        <form class="form-horizontal" method="POST" action="{{url('subircumplido')}}">
                            @csrf
                            <fieldset>

                                <legend>Cumplido de comisión</legend>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" for="comisionid"> <strong> Id. comisión:</strong></label>
                                    <div class="col-sm-3">
                                        <input type="text" readonly class="form-control-plaintext" id="comisionid" value="{{$comision->comisionid}}">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" for="fecharesolucion"> <strong>Fecha de resolución:</strong></label>
                                    <div class="col-sm-5">
                                        <input type="text" readonly class="form-control-plaintext" name="fecharesolucion" id="fecharesolucion" value="{{$comision->fecharesolucion}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" for="fechascomision"> <strong>Fechas de la comisión:</strong></label>
                                    <div class="col-sm-5">
                                        <input type="text" readonly class="form-control-plaintext" id="fechascomision" name="fechascomision" value="{{$comision->fecha}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" for="cumplido1"> <strong>Cumplido 1:</strong></label>
                                    <div class="col-sm-5">
                                        <input type="file" class="input-file" id="cumplido1" name="cumplido1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" for="cumplido2"> <strong>Cumplido 2:</strong></label>
                                    <div class="col-sm-5">
                                        <input type="file" class="input-file" id="cumplido2" name="cumplido2">
                                    </div>
                                </div>


                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0 text-right"><strong>Destinatarios:</strong></legend>
                                    <div class="col-sm-10">

                                        @foreach ($DESTINATARIOS_CUMPLIDOS as $destinatario )


                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="correos[]" value="{{ $destinatario[2] }}">
                                            <label class="form-check-label" for="envio1">
                                                {{ $destinatario[0] }}
                                        </label>
                                        </div>

                                        @endforeach

                                    </div>
                                </div>

                                <br><br>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" for="otrosdestinatario"> <strong>Otros destinatarios:</strong><br>
                                (Correos separados por "  ,  ")</label>
                                    <div class="col-sm-5">
                                        <input id="otrosdestinatario" name="otrosdestinatario" type="text" placeholder="Otros destinatarios" class="form-control input-md">
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group row">
                                    <label class="col-md-4 control-label text-right" for="textarea"><strong>Información complementaria:</strong><br>
                                    <i style="font-size:12px" class="text-justify">
                                    Incluya aquí otra información complementaria que pueda ser de
                                    importancia para los destinatarios del cumplido. Así por
                                    ejemplo, si el cumplido esta relacionado con un Proyecto de
                                    Investigación y desea enviarlo a la dependencia que otorgo
                                    recursos relacionados, indique el nombre del Proyecto.
                                        </i></label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" id="textarea" rows="5" name="textarea"></textarea>
                                    </div>
                                </div>


                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0 text-right"><strong>¿Confirma que desea enviar correo de notificación?</strong></legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="envio1" id="envio1" value="envio1">
                                            <label class="form-check-label" for="envio1">
                                    Si
                                </label>
                                        </div>

                                    </div>
                                </div>


                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="enviar"></label>
                                    <div class="col-md-4">
                                        <button id="enviar" name="enviar" class="btn btn-primary">Cumplir</button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>

                    </div>

                </div>
            </div>
    </main>
@endsection