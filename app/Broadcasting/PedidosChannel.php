<?php

namespace App\Broadcasting;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Auth\User;

class PedidosChannel
{
    public function join(User $user)
    {
        return new PresenceChannel('pedidos');
    }
}
