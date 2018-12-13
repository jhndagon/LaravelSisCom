<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificacionActualizacionProfesorMail extends Mailable
{
    use Queueable, SerializesModels;
    private $comision;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comision)
    {
        $this->comision = $comision;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notificaprofesor')
                    ->from('noreply@gmail.com')
                    ->subject("[Comisiones] Actualización de Solicitud de Comisión/Permiso ". $this->comision->comisionid)
                    ->with('comision', $this->comision);
    }
}
