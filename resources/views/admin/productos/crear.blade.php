@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-black text-white">
                    <h4 class="mb-0">Cargar Nuevo Producto</h4>
                </div>

                <div class="card-body">
                    <!-- IMPORTANTE: enctype="multipart/form-data" es obligatorio para subir archivos -->
                    <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Precio ($)</label>
                                <input type="number" step="0.01" name="precio" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Categoría</label>
                                <select name="categoria" class="form-select" required>
                                    <option value="">Selecciona...</option>
                                    @foreach($categorias as $cat)
                                    <option value="{{ $cat->nombre }}">{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- SECCIÓN DE IMAGEN MEJORADA -->
                        <div class="mb-3 p-3 bg-light border rounded">
                            <label class="form-label fw-bold mb-2">Imagen del Producto</label>

                            <!-- Opción A: Subir Archivo -->
                            <div class="mb-3">
                                <label class="form-label small text-muted">Opción A: Subir foto desde tu PC</label>
                                <input type="file" name="imagen_archivo" class="form-control" accept="image/*">
                            </div>

                            <div class="text-center text-muted small my-2">- O -</div>

                            <!-- Opción B: Pegar Link -->
                            <div class="mb-0">
                                <label class="form-label small text-muted">Opción B: Pegar enlace de internet</label>
                                <input type="url" name="imagen_url" class="form-control" placeholder="https://...">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark">Guardar Producto</button>
                            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection