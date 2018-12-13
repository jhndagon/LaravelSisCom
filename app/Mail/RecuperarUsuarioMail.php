<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecuperarUsuarioMail extends Mailable
{
    use Queueable, SerializesModels;
    private $cedula;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cedula)
    {
        $this->cedula = $cedula;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.recuperarusuario')
        ->subject('[Sistema de comisiones FCEN] Recuperación de usuario')
        ->with('cedula', $this->cedula);
    }
}
