@extends('layouts.plantilla')
@section('contenido')
<div class="container py-4">
    <h2>Editar Categoría</h2>
    <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST" class="card p-4 shadow mt-3">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $categoria->nombre }}" required>
        </div>
        <button class="btn btn-dark">Actualizar</button>
    </form>
</div>
@endsection