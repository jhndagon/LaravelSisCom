<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AprobacionPermisoMail extends Mailable
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
        return $this->view('emails.aprobacionPermiso')
                    ->from('noreply@gmail.com')
                    ->subject('[Comisiones] Su solicitud de comisión/permiso ha sido aprobada')
                    ->with('comision',$this->comision);
    }
}
