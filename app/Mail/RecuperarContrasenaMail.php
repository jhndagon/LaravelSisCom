<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecuperarContrasenaMail extends Mailable
{
    use Queueable, SerializesModels;
    private $contrasena;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contrasena)
    {
        //
        $this->contrasena = $contrasena;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.recuperarcontrasena')
                    ->subject('[Sistema de comisiones FCEN] Recuperación de contraseña')
                    ->with('contrasena', $this->contrasena);
    }
}
