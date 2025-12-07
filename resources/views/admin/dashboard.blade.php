@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">

    <!-- 1. ENCABEZADO Y BOTONES -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Panel de Control</h1>
        <div>
            <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-dark me-2">
                <i class="bi bi-tags"></i> Categorías
            </a>
            <a href="{{ route('admin.productos.index') }}" class="btn btn-dark">
                <i class="bi bi-box-seam"></i> Gestionar Productos
            </a>
        </div>
    </div>

    <!-- 2. TARJETAS DE RESUMEN -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card bg-black text-white shadow h-100 border-0">
                <div class="card-body">
                    <h6 class="text-white-50 text-uppercase small">Ingresos Totales</h6>
                    <h3 class="fw-bold mb-0">${{ number_format($pedidos->sum('total'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-white border shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase small">Pedidos Recibidos</h6>
                            <h3 class="fw-bold text-dark mb-0">{{ $pedidos->count() }}</h3>
                        </div>
                        <i class="bi bi-bag-check fs-1 text-black-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-white border shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase small">Productos Vendidos</h6>
                            <h3 class="fw-bold text-dark mb-0">
                                {{ DB::table('detalle_pedidos')->sum('cantidad') }} u.
                            </h3>
                        </div>
                        <i class="bi bi-basket fs-1 text-black-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABLA DE PEDIDOS -->
    <div class="card shadow border-0 mb-5">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold">Gestión de Pedidos</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#Pedido</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Estado Actual (Cambiar)</th>
                            <th>Total</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedidos as $pedido)

                        <!-- LÓGICA SIMPLIFICADA: Elegimos la clase CSS en lugar del color -->
                        @php
                        // Clase por defecto (Gris)
                        $claseEstado = 'form-select form-select-sm fw-bold border-secondary text-secondary';

                        if($pedido->estado == 'listo') {
                        // Verde para listo
                        $claseEstado = 'form-select form-select-sm fw-bold border-success text-success';
                        } elseif($pedido->estado == 'pendiente') {
                        // Amarillo para pendiente
                        $claseEstado = 'form-select form-select-sm fw-bold border-warning text-dark';
                        } elseif($pedido->estado == 'pagado' || $pedido->estado == 'mercadopago') {
                        // Azul para pagado
                        $claseEstado = 'form-select form-select-sm fw-bold border-info text-dark';
                        } elseif($pedido->estado == 'cancelado') {
                        // Rojo para cancelado
                        $claseEstado = 'form-select form-select-sm fw-bold border-danger text-danger';
                        }
                        @endphp

                        <tr>
                            <td class="ps-4 fw-bold">#{{ $pedido->id }}</td>
                            <td>
                                <div class="fw-bold">{{ $pedido->user->name }}</div>
                                <small class="text-muted">{{ $pedido->user->email }}</small>
                            </td>
                            <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>

                            <!-- SELECTOR DE ESTADO LIMPIO -->
                            <td>
                                <form action="{{ route('admin.pedidos.update_estado', $pedido->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Aquí usamos SOLO la variable de clase, sin estilos raros -->
                                    <select name="estado" class="{{ $claseEstado }}"
                                        onchange="this.form.submit()"
                                        style="width: 160px; cursor: pointer;">

                                        <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>⏳ Pendiente</option>
                                        <option value="pagado" {{ $pedido->estado == 'pagado' || $pedido->estado == 'mercadopago' ? 'selected' : '' }}>💲 Pagado</option>
                                        <option value="listo" {{ $pedido->estado == 'listo' ? 'selected' : '' }}>✅ Listo p/ Retirar</option>
                                        <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>📦 Entregado</option>
                                        <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>❌ Cancelado</option>
                                    </select>
                                </form>
                            </td>

                            <td class="fw-bold">${{ number_format($pedido->total, 0, ',', '.') }}</td>

                            <!-- BOTÓN VER DETALLE -->
                            <td>
                                <button class="btn btn-sm btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#detalle{{ $pedido->id }}">
                                    Ver Items <i class="bi bi-chevron-down"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- FILA DESPLEGABLE (DETALLE) -->
                        <tr class="collapse bg-light" id="detalle{{ $pedido->id }}">
                            <td colspan="6" class="p-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">📦 Productos del Pedido:</h6>
                                        <ul class="list-group list-group-flush">
                                            @foreach($pedido->productos as $prod)
                                            <li class="list-group-item d-flex justify-content-between bg-transparent">
                                                <span>{{ $prod->pivot->cantidad }}x {{ $prod->nombre }}</span>
                                                <span class="fw-bold">${{ number_format($prod->pivot->precio * $prod->pivot->cantidad, 0, ',', '.') }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">No hay pedidos registrados todavía.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection