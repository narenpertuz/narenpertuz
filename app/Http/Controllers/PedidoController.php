<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Events\PedidoCreado;
use Illuminate\Http\Request;
use App\Services\PedidoService;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;

class PedidoController extends Controller
{
    protected $pedidoService;

    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }

    public function index()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos);
    }

    public function store(Request $request)
    {
        // Llamada al método del servicio para crear un pedido
        $pedido = $this->pedidoService->createPedido($request->all());
        return response()->json($pedido, 201);
    }

    public function show($idPedido)
    {
        // Llamada al método del servicio para obtener un pedido
        $pedido = $this->pedidoService->getPedido($idPedido);
        return response()->json($pedido);
    }

    public function update(Request $request, $idPedido)
    {
        $pedido = Pedido::findOrFail($idPedido);
    
        // Llamada al método del servicio para actualizar un pedido
        $this->pedidoService->updatePedido($request->all(), $idPedido);
        return response()->json($pedido, 200);
    }    

    public function destroy($idPedido)
    {
        // Llamada al método del servicio para eliminar un pedido
        $this->pedidoService->deletePedido($idPedido);
        return response()->json(null, 204);
    }
}
