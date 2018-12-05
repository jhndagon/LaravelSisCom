<?php

namespace Comisiones\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AprobacionMail extends Mailable
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
        // dd(\storage_path('app/comisiones') .'/' . $this->comision->comisionid . '/resolucion-' . $this->comision->comisionid . '.pdf');
        return $this->view('emails.aprobacion')
                    ->from('noreply@gmail.com')
                    ->subject('[Comisiones] Su solicitud de comisión/permiso ha sido aprobada')
                    ->attach(\storage_path('app/comisiones') . '/' . $this->comision->comisionid . '/resolucion-' . $this->comision->comisionid . '.pdf',['mime'=>'pdf'])
                    ->with('comision',$this->comision);
    }
}
