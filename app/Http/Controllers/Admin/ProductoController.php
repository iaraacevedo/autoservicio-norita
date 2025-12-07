<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage; // Necesario para manejar archivos

class ProductoController extends Controller
{
    // 1. Panel Principal y Lista de Productos
    public function index()
    {
        // Si la ruta es "admin/productos", mostramos la TABLA DE GESTIÓN
        if (request()->routeIs('admin.productos.index')) {
            $productos = Producto::all();
            return view('admin.productos.index', compact('productos'));
        }

        // Si la ruta es "admin" (Dashboard), mostramos los CUADROS DE ESTADÍSTICA
        $pedidos = Pedido::with(['user', 'productos'])->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('pedidos'));
    }

    // 2. Formulario de Crear
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.productos.crear', compact('categorias'));
    }

    // 3. Guardar en Base de Datos (Con lógica de Imagen)
    public function store(Request $request)
    {
        // Validamos (la imagen puede ser archivo O url, no obligamos a una específica aquí)
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'categoria' => 'required',
            'imagen_archivo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validar archivo
            'imagen_url' => 'nullable|url', // Validar URL
        ]);

        // Lógica de la imagen por defecto
        $rutaImagen = 'https://via.placeholder.com/300';

        // OPCIÓN A: Subió un archivo desde su PC
        if ($request->hasFile('imagen_archivo')) {
            // Guardamos en la carpeta 'public/productos'
            $path = $request->file('imagen_archivo')->store('productos', 'public');
            // Agregamos '/storage/' para que el navegador la pueda ver
            $rutaImagen = '/storage/' . $path;
        }
        // OPCIÓN B: Pegó un link de internet
        elseif ($request->filled('imagen_url')) {
            $rutaImagen = $request->input('imagen_url');
        }

        Producto::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'stock' => 9999, // Stock infinito
            'categoria' => $request->input('categoria'),
            'imagen_url' => $rutaImagen, // Guardamos la ruta final
            'activo' => true // Nace visible
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    // 4. Formulario de Editar
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.productos.editar', compact('producto', 'categorias'));
    }

    // 5. Actualizar Cambios
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'categoria' => 'required',
        ]);

        // Mantenemos la imagen que ya tenía por defecto
        $rutaImagen = $producto->imagen_url;

        // Si sube UNA NUEVA, la reemplazamos
        if ($request->hasFile('imagen_archivo')) {
            // (Opcional: Podríamos borrar la imagen vieja del servidor aquí)
            $path = $request->file('imagen_archivo')->store('productos', 'public');
            $rutaImagen = '/storage/' . $path;
        }
        // Si cambia el LINK, lo actualizamos
        elseif ($request->filled('imagen_url')) {
            $rutaImagen = $request->input('imagen_url');
        }

        $producto->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'categoria' => $request->input('categoria'),
            'imagen_url' => $rutaImagen,
        ]);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado.');
    }

    // 6. Eliminar definitivamente
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado.');
    }

    // 7. Ocultar/Mostrar (Ojo)
    public function toggleVisibility($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->activo = !$producto->activo;
        $producto->save();

        $estado = $producto->activo ? 'visible' : 'oculto';
        return redirect()->back()->with('success', "El producto ahora está $estado.");
    }
}
