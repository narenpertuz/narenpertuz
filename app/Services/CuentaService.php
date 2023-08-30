<?php

namespace App\Services;

use App\Models\Cuenta;

class CuentaService
{
    public function getCuentas()
    {
        return Cuenta::all();
    }

    public function createCuenta(array $data)
    {
        return Cuenta::create($data);
    }

    public function getCuenta($idCuenta)
    {
        return Cuenta::findOrFail($idCuenta);
    }

    public function updateCuenta(array $data, $idCuenta)
    {
        $cuenta = Cuenta::findOrFail($idCuenta);
        $cuenta->update($data);
        return $cuenta;
    }    

    public function deleteCuenta($idCuenta)
    {
        $cuenta = Cuenta::findOrFail($idCuenta);
        $cuenta->delete();
    }
}
