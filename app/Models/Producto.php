<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; // Forzamos el nombre por si acaso

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen_url',
        'categoria',
        'activo'
    ];

    // Relación: Un producto puede estar en muchos pedidos
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'detalle_pedidos')
            ->withPivot('cantidad', 'precio')
            ->withTimestamps();
    }
}
