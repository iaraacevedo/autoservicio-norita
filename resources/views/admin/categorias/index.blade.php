@extends('layouts.plantilla')
@section('contenido')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Categorías</h2>
        <a href="{{ route('admin.categorias.create') }}" class="btn btn-dark">Nueva Categoría</a>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td>{{ $cat->nombre }}</td>
                        <td>
                            <a href="{{ route('admin.categorias.edit', $cat->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.categorias.destroy', $cat->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Borrar?')">Borrar</button>
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