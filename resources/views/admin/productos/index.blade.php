@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Listado de Productos</h2>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg"></i> Nuevo Producto
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Estado</th> <!-- Aquí va el Ojo -->
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $prod)
                    <tr class="{{ $prod->activo ? '' : 'table-secondary text-muted' }}">
                        <td>
                            <img src="{{ $prod->imagen_url }}" width="50" height="50" class="rounded object-fit-cover">
                        </td>
                        <td class="fw-bold">{{ $prod->nombre }}</td>
                        <td>${{ number_format($prod->precio, 0, ',', '.') }}</td>
                        <td><span class="badge bg-secondary">{{ $prod->categoria }}</span></td>
                        <td>
                            <!-- Botón de Visibilidad (Ojo) -->
                            @if($prod->activo)
                            <a href="{{ route('admin.productos.toggle', $prod->id) }}" class="btn btn-sm btn-outline-success" title="Click para Ocultar">
                                <i class="bi bi-eye-fill"></i> Visible
                            </a>
                            @else
                            <a href="{{ route('admin.productos.toggle', $prod->id) }}" class="btn btn-sm btn-outline-secondary" title="Click para Mostrar">
                                <i class="bi bi-eye-slash-fill"></i> Oculto
                            </a>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.productos.edit', $prod->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.productos.destroy', $prod->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Borrar definitivamente?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection