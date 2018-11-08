<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecuperarUsuarioMail extends Mailable
{
    use Queueable, SerializesModels;
    private $usuario;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario)
    {
        $this->usuario = $usuario;
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
        ->with('usuario', $this->usuario);
    }
}
