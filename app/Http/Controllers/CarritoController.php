<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    // 1. Mostrar el carrito
    public function index()
    {
        $carrito = session()->get('carrito', []); // Recuperamos la mochila
        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('tienda.carrito', compact('carrito', 'total'));
    }

    // 2. Agregar producto
    public function agregar(Request $request, $id)
    {

        $producto = Producto::findOrFail($id);
        $carrito = session()->get('carrito', []);
        $cantidad = $request->input('cantidad', 1);

        // Si el producto ya está, sumamos la cantidad
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            // Si es nuevo, lo agregamos con sus datos
            $carrito[$id] = [
                "nombre" => $producto->nombre,
                "cantidad" => $cantidad,
                "precio" => $producto->precio,
                "imagen" => $producto->imagen_url
            ];
        }

        session()->put('carrito', $carrito); // Guardamos en la mochila
        return redirect()->back()->with('success', '¡Producto agregado al carrito!');
    }

    // 3. Eliminar un producto
    public function eliminar($id)
    {
        $carrito = session()->get('carrito');
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('success', 'Producto eliminado.');
    }

    // 4. Vaciar todo
    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Carrito vaciado.');
    }
}
