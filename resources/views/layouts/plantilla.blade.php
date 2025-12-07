<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoservicio Norita</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Fuente Moderna: Poppins (Google Fonts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* 1. Fuente y Fondo */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            /* Un gris un pelín más azulado/moderno */
        }

        /* 2. Barra de Navegación */
        .navbar {
            background: linear-gradient(to right, #000000, #1a1a1a);
            /* Degradado sutil */
            border-bottom: 3px solid #ffc107;
            /* Línea dorada/amarilla abajo para dar color */
        }

        .navbar-brand img {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .navbar-brand img:hover {
            transform: scale(1.1) rotate(-2deg);
            /* Efecto divertido al pasar el mouse */
        }

        /* 3. Tarjetas de Productos (Cards) */
        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-10px);
            /* Se levanta */
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            /* Sombra suave */
        }

        .product-image-container {
            height: 220px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
        }

        .product-image-container img {
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.05);
            /* Zoom suave en la foto */
        }

        /* 4. Botones */
        .btn-norita {
            background-color: #000;
            color: #fff;
            border-radius: 50px;
            /* Botones redondos */
            padding: 8px 20px;
            border: 2px solid #000;
            transition: all 0.3s;
        }

        .btn-norita:hover {
            background-color: transparent;
            color: #000;
        }

        /* 5. Footer */
        footer {
            background: #111;
            color: #aaa;
        }

        footer h5 {
            color: #fff;
            border-left: 3px solid #ffc107;
            /* Detalle de color */
            padding-left: 10px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100"> <!-- Flex para que el footer siempre quede abajo -->

    <!-- BARRA DE NAVEGACIÓN (Negro Puro) -->
    <!-- Agregamos py-3 para dar más altura a la barra -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow py-3" style="background-color: #000;">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('tienda.index') }}">
                <!-- AUMENTADO: height: 90px y width: auto para que se vea grande y alargado -->
                <img src="{{ asset('img/logo.jpg') }}" alt="Autoservicio Norita" style="height: 90px; width: auto;">
            </a>

            <!-- Botón Hamburguesa para Móvil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú Derecho -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center gap-3">

                    <!-- Botón Carrito -->
                    <a href="{{ route('carrito.index') }}" class="btn btn-light position-relative shadow-sm rounded-pill px-3">
                        <i class="bi bi-cart-fill"></i> Carrito
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                            {{ count((array) session('carrito')) }}
                        </span>
                    </a>

                    <!-- Menú de Usuario -->
                    @guest
                    <div class="vr text-white mx-2 d-none d-lg-block"></div> <!-- Separador vertical -->
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Ingresar</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm fw-bold">Registrarse</a>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            @if(Auth::user()->rol == 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Panel Admin</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('tienda.mis_pedidos') }}"><i class="bi bi-bag-check"></i> Mis Pedidos</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- ALERTAS -->
    @if(session('success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container my-4 flex-grow-1">
        @yield('contenido')
    </div>

    <!-- PIE DE PÁGINA (Footer) Profesional -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Autoservicio Norita</h5>
                    <p class="small text-white-50">
                        La calidad de siempre, ahora online. Hacé tu pedido y retirá sin esperas.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Contacto</h5>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2">
                            <a href="https://maps.google.com/?q=Avenida+Sabin+781+Resistencia" target="_blank" class="text-white-50 text-decoration-none">
                                <i class="bi bi-geo-alt-fill me-2"></i> Av. Sabin 781, Resistencia
                            </a>
                        </li>
                        <li class="mb-2">
                            <!-- Reemplaza el numero 549... con el real de Norita -->
                            <a href="https://wa.me/5493624000000?text=Hola+Norita+tengo+una+consulta" target="_blank" class="text-white-50 text-decoration-none">
                                <i class="bi bi-whatsapp me-2"></i> 3624-XXXXXX
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Horarios</h5>
                    <p class="small text-white-50">
                        Lunes a Sábado<br>
                        08:00 - 13:00 hs<br>
                        17:00 - 21:00 hs
                    </p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small text-white-50">
                <p class="mb-0">© 2025 Autoservicio Norita</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>