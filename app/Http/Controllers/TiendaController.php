<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria; // <--- Importamos el modelo

class TiendaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Traemos TODAS las categorías de la base de datos para el filtro
        $categorias = Categoria::all();

        // 2. Iniciamos la consulta de productos
        $query = Producto::where('activo', true);

        // Filtro por Buscador
        if ($request->has('buscar') && $request->buscar != '') {
            $busqueda = $request->input('buscar');
            $query->where('nombre', 'LIKE', "%{$busqueda}%");
        }

        // Filtro por Categoría (Ahora comparamos con el nombre real)
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria', $request->input('categoria'));
        }

        $productos = $query->get();

        // Pasamos tanto $productos como $categorias a la vista
        return view('tienda.catalogo', compact('productos', 'categorias'));
    }

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('tienda.detalle', compact('producto'));
    }
}
