<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Events\PedidoCreado;
use Illuminate\Http\Request;
use App\Services\PedidoService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
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
    
        // Obtener información del cliente relacionado con el pedido
        $cliente = $pedido->cuenta;

        // Emitir el evento PedidoCreado con información del cliente y el pedido
        event(new PedidoCreado($pedido, $cliente));
        Log::info('Evento PedidoCreado emitido');

        // Enviar los datos del pedido y cliente al servidor WebSocket
        $this->sendToWebSocketServer($pedido, $cliente);

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

    private function sendToWebSocketServer($pedido, $cliente)
    {
        $webSocketServerUrl = 'http://localhost:3000';
        $data = [
            'pedido' => $pedido,
            'cliente' => $cliente,
        ];

        try {
            Http::post($webSocketServerUrl, $data);
            Log::info('Datos del pedido y cliente enviados al servidor WebSocket');
        } catch (\Exception $e) {
            Log::error('Error al enviar datos al servidor WebSocket: ' . $e->getMessage());
        }
    }
}
