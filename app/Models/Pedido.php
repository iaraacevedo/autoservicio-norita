<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'metodo_pago',
        'estado',
        'mercadopago_id'
    ];

    // El pedido pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un pedido tiene muchos productos (conectados mediante la tabla detalle)
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_pedidos')
            ->withPivot('cantidad', 'precio'); // Queremos acceder a estos datos extra
    }
}
