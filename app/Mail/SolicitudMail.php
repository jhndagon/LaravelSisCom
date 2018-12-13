<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudMail extends Mailable
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
        $this->view('emails.solicitudcomision')
                    ->from('noreply@gmail.com')
                    ->subject('[Comisiones] Nueva solicitud de comisión requiere visto bueno.')
                    ->with('comision',$this->comision);
    }
}
