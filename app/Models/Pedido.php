<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $primaryKey = 'idPedido';
    protected $fillable = ['idCuenta', 'producto', 'cantidad', 'valor', 'total'];

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'idCuenta');
    }
}
