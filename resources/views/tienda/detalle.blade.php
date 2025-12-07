@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 text-center">
            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="img-fluid rounded shadow" style="max-height: 500px;">
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold">{{ $producto->nombre }}</h1>
            <p class="text-muted">Categoría: <span class="badge bg-secondary">{{ $producto->categoria }}</span></p>

            <h2 class="text-dark my-4 fw-bold">${{ number_format($producto->precio, 0, ',', '.') }}</h2>

            <p class="lead">{{ $producto->descripcion }}</p>

            <hr>

            <form action="{{ route('carrito.add', $producto->id) }}" method="POST">
                @csrf
                <div class="row align-items-end">
                    <div class="col-auto">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <select name="cantidad" id="cantidad" class="form-select">
                            <option value="1">1 unidad</option>
                            <option value="2">2 unidades</option>
                            <option value="3">3 unidades</option>
                            <option value="5">5 unidades</option>
                        </select>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-success w-100 btn-lg">
                            <i class="bi bi-cart-plus-fill"></i> Agregar al Carrito
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-4">
                <a href="{{ route('tienda.index') }}" class="text-decoration-none text-dark">
                    <i class="bi bi-arrow-left"></i> Volver al catálogo
                </a>
            </div>
        </div>
    </div>
</div>
@endsection