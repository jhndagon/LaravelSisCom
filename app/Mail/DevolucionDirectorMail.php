<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DevolucionDirectorMail extends Mailable
{
    use Queueable, SerializesModels;
    private $comision;
    private $espuesta;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comision, $respuesta)
    {
        $this->comision = $comision;
        $this->respuesta = $respuesta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('emails.devolucion')
                    ->from('noreply@gmail.com')
                    ->subject('[Copia][Comision] Su solicitud de comisión/permiso ha sido devuelta.')
                    ->with('comision',$this->comision)
                    ->with('respuesta', $this->respuesta);
    }
}
