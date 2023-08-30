<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $primaryKey = 'idCuenta';
    protected $fillable = ['nombre', 'email', 'telefono'];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'idCuenta');
    }
}
