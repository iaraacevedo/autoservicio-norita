@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Mis Pedidos</h2>

    @if($pedidos->count() > 0)
    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#Pedido</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                        <tr>
                            <td class="fw-bold">#{{ $pedido->id }}</td>
                            <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                            <td>
                                <!-- Lógica de colores según estado -->
                                @if($pedido->estado == 'pendiente')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                                @elseif($pedido->estado == 'pagado' || $pedido->estado == 'mercadopago')
                                <span class="badge bg-info text-dark">Pagado / En proceso</span>
                                @elseif($pedido->estado == 'listo')
                                <span class="badge bg-success fs-6">¡Listo para retirar! 🎁</span>
                                @else
                                <span class="badge bg-secondary">{{ ucfirst($pedido->estado) }}</span>
                                @endif
                            </td>
                            <td class="fw-bold">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#pedido{{ $pedido->id }}">
                                    Ver qué compré
                                </button>
                            </td>
                        </tr>
                        <!-- Desplegable con los productos -->
                        <tr class="collapse bg-light" id="pedido{{ $pedido->id }}">
                            <td colspan="5" class="p-3">
                                <ul class="list-group list-group-flush">
                                    @foreach($pedido->productos as $prod)
                                    <li class="list-group-item bg-transparent d-flex justify-content-between">
                                        <span>{{ $prod->pivot->cantidad }}x {{ $prod->nombre }}</span>
                                        <span class="text-muted">${{ number_format($prod->pivot->precio, 0, ',', '.') }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        Todavía no hiciste ninguna compra. <a href="{{ route('tienda.index') }}" class="fw-bold">¡Ir al catálogo!</a>
    </div>
    @endif
</div>
@endsection