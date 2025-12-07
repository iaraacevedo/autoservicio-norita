@extends('layouts.plantilla')
@section('contenido')
<div class="container py-4">
    <h2>Nueva Categoría</h2>
    <form action="{{ route('admin.categorias.store') }}" method="POST" class="card p-4 shadow mt-3">
        @csrf
        <div class="mb-3">
            <label>Nombre de la Categoría</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <button class="btn btn-dark">Guardar</button>
    </form>
</div>
@endsection