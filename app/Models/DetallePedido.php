<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedidos'; // Importante para que encuentre la tabla

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio'
    ];
}
