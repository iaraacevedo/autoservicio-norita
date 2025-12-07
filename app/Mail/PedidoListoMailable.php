<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pedido;

class PedidoListoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function build()
    {
        return $this->view('emails.pedido_listo')
            ->subject('🎁 ¡Tu pedido en Norita está listo para retirar!');
    }
}
