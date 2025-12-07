@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">
    <h1 class="mb-4 fw-bold">Tu Carrito de Compras</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('carrito') && count(session('carrito')) > 0)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th class="text-end pe-4">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('carrito') as $id => $details)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $details['imagen'] }}" width="60" height="60" class="rounded me-3 object-fit-cover border">
                                    <span class="fw-bold">{{ $details['nombre'] }}</span>
                                </div>
                            </td>
                            <td>${{ number_format($details['precio'], 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $details['cantidad'] }}</span>
                            </td>
                            <td class="fw-bold">${{ number_format($details['precio'] * $details['cantidad'], 0, ',', '.') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('carrito.remove', $id) }}" class="btn btn-outline-danger btn-sm border-0" title="Eliminar">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Botón Vaciar (Izquierda) -->
        <div class="col-md-6 mb-3 mb-md-0">
            <a href="{{ route('carrito.clear') }}" class="btn btn-outline-secondary">
                <i class="bi bi-trash"></i> Vaciar Carrito
            </a>
        </div>

        <!-- Resumen y Pagos (Derecha) -->
        <div class="col-md-6 text-md-end">
            <div class="bg-light p-4 rounded border">
                <h3 class="mb-4 fw-bold">Total: ${{ number_format($total, 0, ',', '.') }}</h3>

                <div class="d-grid gap-2">
                    <!-- Opción A: Efectivo (Principal - Negro) -->
                    <form action="{{ route('pedido.confirmar_efectivo') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-dark btn-lg w-100 py-3">
                            <i class="bi bi-shop me-2"></i> Pagar al Retirar (Efectivo)
                        </button>
                    </form>

                    <!-- Opción B: Mercado Pago (Secundaria - Borde Negro) -->
                    <form action="{{ route('pedido.confirmar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark btn-lg w-100 py-2">
                            <i class="bi bi-credit-card-2-front me-2"></i> Pagar Online (Mercado Pago)
                        </button>
                    </form>
                </div>

                <div class="mt-3 text-center">
                    <a href="{{ route('tienda.index') }}" class="text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left"></i> Seguir comprando
                    </a>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
        </div>
        <h3 class="text-muted">Tu carrito está vacío</h3>
        <p class="mb-4">Parece que todavía no has agregado productos.</p>
        <a href="{{ route('tienda.index') }}" class="btn btn-dark px-4 py-2">Ir a comprar</a>
    </div>
    @endif
</div>
@endsection