<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PedidoCreado implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pedido;
    public $cliente;

    public function __construct($pedido, $cliente)
    {
        $this->pedido = $pedido;
        $this->cliente = $cliente;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('pedidos');
    }

    public function broadcastWith()
    {
        return [
            'pedido' => $this->pedido,
            'cliente' => $this->cliente,
        ];
    }
}
