@extends('layouts.plantilla')

@section('contenido')

<!-- 1. HERO BANNER (Portada con Imagen) -->
<div class="mb-5 position-relative rounded-3 overflow-hidden shadow-lg"
    style="background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop'); 
            background-size: cover; background-position: center; height: 400px;">

    <!-- Capa oscura (Overlay) para que se lea el texto blanco -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.6);"></div>

    <div class="position-relative h-100 d-flex flex-column justify-content-center align-items-center text-center text-white p-4">
        <h1 class="display-3 fw-bold mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Autoservicio Norita</h1>
        <p class="lead fs-4 mb-4">Llená tu heladera sin moverte de tu casa.</p>
        <a class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow text-dark" href="#productos">
            <i class="bi bi-cart3 me-2"></i> Ver Ofertas
        </a>
    </div>
</div>

<div id="productos"></div>

<!-- 2. BARRA DE BÚSQUEDA Y FILTROS -->
<div class="container mb-5">
    <form action="{{ route('tienda.index') }}" method="GET">
        <div class="row g-2 align-items-center justify-content-center">
            <!-- Selector de Categoría -->
            <div class="col-md-3">
                <select name="categoria" class="form-select border-2" onchange="this.form.submit()" style="border-radius: 20px;">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                    <option value="{{ $cat->nombre }}" {{ request('categoria') == $cat->nombre ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Barra de Texto -->
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="buscar" class="form-control border-2" placeholder="¿Qué estás buscando hoy?" value="{{ request('buscar') }}" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                    <button class="btn btn-dark px-4" type="submit" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                        <i class="bi bi-search"></i> Buscar
                    </button>

                    @if(request('buscar') || request('categoria'))
                    <a href="{{ route('tienda.index') }}" class="btn btn-outline-secondary ms-2 rounded-circle" title="Limpiar filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<!-- 3. GRILLA DE PRODUCTOS (Diseño Tarjetas) -->
<div class="row g-4">
    <div class="col-12 mb-2">
        <h2 class="text-center fw-bold text-uppercase ls-2">
            <span class="border-bottom border-3 border-warning pb-1">Nuestros Productos</span>
        </h2>
    </div>

    @foreach($productos as $producto)
    <div class="col-md-4 col-lg-3">
        <div class="card product-card h-100 shadow-sm border-0"> <!-- Clase personalizada product-card -->

            <!-- Contenedor de imagen para que todas se vean iguales -->
            <div class="product-image-container position-relative">
                <img src="{{ $producto->imagen_url }}" class="img-fluid" alt="{{ $producto->nombre }}">

                @if(!$producto->activo)
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75">
                    <span class="badge bg-secondary">Sin Stock</span>
                </div>
                @endif
            </div>

            <div class="card-body d-flex flex-column text-center pt-4">
                <!-- Categoría pequeña arriba -->
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">
                    {{ $producto->categoria }}
                </small>

                <h5 class="card-title fw-bold my-2">{{ $producto->nombre }}</h5>
                <p class="card-text text-muted small flex-grow-1">{{ Str::limit($producto->descripcion, 40) }}</p>

                <div class="mt-3">
                    <h3 class="fw-bold mb-3 text-dark">${{ number_format($producto->precio, 0, ',', '.') }}</h3>

                    <div class="d-grid gap-2 px-3 pb-2">
                        <!-- Botón Ver Detalle -->
                        <a href="{{ route('tienda.show', $producto->id) }}" class="btn btn-outline-dark rounded-pill btn-sm">
                            Ver Detalle
                        </a>

                        <!-- Botón Agregar (Estilo Norita) -->
                        <form action="{{ route('carrito.add', $producto->id) }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-norita btn-sm">
                                <i class="bi bi-cart-plus me-1"></i> Agregar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection