<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // 1. Mostrar la lista de categorías
    public function index()
    {
        $categorias = Categoria::all();
        return view('admin.categorias.index', compact('categorias'));
    }

    // 2. Mostrar el formulario de creación
    public function create()
    {
        return view('admin.categorias.create');
    }

    // 3. Guardar la nueva categoría en la BD
    public function store(Request $request)
    {
        // Validamos que el nombre sea obligatorio
        $request->validate([
            'nombre' => 'required|max:255'
        ]);

        // Creamos la categoría con todos los datos del formulario
        Categoria::create($request->all());

        return redirect()->route('admin.categorias.index')->with('success', '¡Categoría creada con éxito!');
    }

    // 4. Mostrar formulario de edición
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    // 5. Actualizar los cambios en la BD
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255'
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    // 6. Borrar categoría
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada.');
    }
}
