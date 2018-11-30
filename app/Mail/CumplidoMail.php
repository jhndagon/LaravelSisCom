<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CumplidoMail extends Mailable
{
    use Queueable, SerializesModels;

    private $comision;
    private $nombre;
    private $envioa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comision, $nombre, $envioa)
    {
        $this->comision = $comision;
        $this->nombre = $nombre;
        $this->envioa = $envioa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.cumplido')
                    ->from('noreply@gmail.com')
                    ->subject('[Cumplido FCEN] '.$this->nombre .' ha enviado un cumplido por la actividad realizada en '. $this->comision->fecha .'.')
                    ->with('comision', $this->comision)
                    ->with('nombre', $this->nombre)
                    ->with('envioa', $this->envioa);
    }
}
