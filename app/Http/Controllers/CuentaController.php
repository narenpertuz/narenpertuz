<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use App\Services\CuentaService;

class CuentaController extends Controller
{
    protected $cuentaService;

    public function __construct(CuentaService $cuentaService)
    {
        $this->cuentaService = $cuentaService;
    }

    public function index()
    {
        $cuentas = Cuenta::all();
        return response()->json($cuentas);
    }

    public function store(Request $request)
    {
        // Llamada al método del servicio para crear una cuenta
        $cuenta = $this->cuentaService->createCuenta($request->all());
        return response()->json($cuenta, 201);
    }

    public function show($idCuenta)
    {
        $cuenta = $this->cuentaService->getCuenta($idCuenta);
        return response()->json($cuenta);
    }

    public function update(Request $request, $idCuenta)
    {
        // Llamada al método del servicio para actualizar la cuenta
        $cuenta = $this->cuentaService->updateCuenta($request->all(), $idCuenta);
        return response()->json($cuenta, 200);
    }    

    public function destroy($idCuenta)
    {
        // Llamada al método del servicio para eliminar la cuenta
        $this->cuentaService->deleteCuenta($idCuenta);
        return response()->json(null, 204);
    }    
}
