<?php

namespace App\Services;

use App\Models\Cuenta;
use App\Models\Pedido;
use App\Events\PedidoCreado;

class PedidoService
{
    public function getPedidos()
    {
        return Pedido::all();
    }

    public function createPedido(array $data)
    {
        return Pedido::create($data);
    }

    public function getPedido($idPedido)
    {
        return Pedido::findOrFail($idPedido);
    }

    public function updatePedido(array $data, $idPedido)
    {
        $pedido = Pedido::findOrFail($idPedido);
        $pedido->update($data);
        return $pedido;
    }

    public function deletePedido($idPedido)
    {
        $pedido = Pedido::findOrFail($idPedido);
        $pedido->delete();
    }
}
