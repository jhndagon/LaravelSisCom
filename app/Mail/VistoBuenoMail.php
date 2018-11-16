<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VistoBuenoMail extends Mailable
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
        return $this->view('emails.vistobueno')
                    ->from('noreply@gmail.com')
                    ->subject('[Comisiones] Una solicitud de comisión ha recibido visto bueno.')
                    ->with('comision',$this->comision);
    }
}