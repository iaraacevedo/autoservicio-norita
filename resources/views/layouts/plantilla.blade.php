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

    <!-- Fuente Moderna: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* --- 0. REGLA MAESTRA: ADIÓS AZUL (Variable Override) --- */
        :root {
            --bs-primary: #000000;
            --bs-primary-rgb: 0, 0, 0;
            --bs-link-color: #000000;
            --bs-link-hover-color: #333333;
            --bs-focus-ring-color: rgba(0, 0, 0, 0.25);
        }

        /* 1. FUENTE GLOBAL */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }

        /* --- TUS ESTILOS PREMIUM --- */
        .navbar {
            background: linear-gradient(to right, #000000, #1a1a1a) !important;
            border-bottom: 3px solid #ffc107;
        }

        .navbar-brand img {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .navbar-brand img:hover {
            transform: scale(1.1) rotate(-2deg);
        }

        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
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
        }

        .btn-norita {
            background-color: #000;
            color: #fff;
            border-radius: 50px;
            padding: 8px 20px;
            border: 2px solid #000;
            transition: all 0.3s;
        }

        .btn-norita:hover {
            background-color: transparent;
            color: #000;
        }

        footer {
            background: #111;
            color: #aaa;
        }

        footer h5 {
            color: #fff;
            border-left: 3px solid #ffc107;
            padding-left: 10px;
        }

        /* --- PARCHES DE SEGURIDAD VISUAL --- */
        .btn-primary {
            background-color: #000000 !important;
            border-color: #000000 !important;
        }

        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary:focus {
            background-color: #333333 !important;
            border-color: #333333 !important;
        }

        .btn-outline-primary {
            color: #000000 !important;
            border-color: #000000 !important;
        }

        .btn-outline-primary:hover {
            background-color: #000000 !important;
            color: #ffffff !important;
        }

        .text-primary {
            color: #000000 !important;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* CORRECCIÓN MENÚ DESPLEGABLE */
        .dropdown-item {
            color: #000000 !important;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: #e9ecef !important;
            color: #000000 !important;
        }

        .dropdown-item:active,
        .dropdown-item.active {
            background-color: #000000 !important;
            color: #ffffff !important;
        }

        /* CORRECCIÓN FORMULARIOS */
        .form-control:focus,
        .form-select:focus {
            border-color: #000000 !important;
            box-shadow: 0 0 0 0.25rem rgba(0, 0, 0, 0.1) !important;
        }

        /* --- SOLUCIÓN NUCLEAR --- */
        /* Esto elimina el contorno azul por defecto del navegador al hacer clic en CUALQUIER cosa */
        *:focus {
            outline: none !important;
            box-shadow: none !important;
            /* Si prefieres una sombra negra sutil, cambia 'none' por la sombra */
        }

        /* Restauramos un foco sutil solo para inputs para que se sepa dónde se escribe */
        input:focus,
        select:focus,
        textarea:focus {
            border-color: #000 !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, .25) !important;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow py-3">
        <div class="container">
            <!-- Logo Grande -->
            <a class="navbar-brand" href="{{ route('tienda.index') }}">
                <img src="{{ asset('img/logo.jpg') }}" alt="Autoservicio Norita" style="height: 80px; width: auto;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center gap-3">

                    <!-- Botón Carrito -->
                    <a href="{{ route('carrito.index') }}" class="btn btn-light position-relative shadow-sm rounded-pill px-3">
                        <i class="bi bi-cart-fill"></i> Carrito
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                            {{ count((array) session('carrito')) }}
                        </span>
                    </a>

                    <!-- Menú Usuario -->
                    @guest
                    <div class="vr text-white mx-2 d-none d-lg-block"></div>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Ingresar</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm fw-bold rounded-pill px-3">Registrarse</a>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            @if(Auth::user()->rol == 'admin')
                            <li><a class="dropdown-item fw-bold" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Panel Admin</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @endif

                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear"></i> Mi Perfil</a></li>
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
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 bg-success text-white" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <!-- CONTENIDO -->
    <div class="container my-4 flex-grow-1">
        @yield('contenido')
    </div>

    <!-- FOOTER -->
    <footer class="pt-5 pb-3 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3 border-secondary pb-2 d-inline-block">Autoservicio Norita</h5>
                    <p class="small text-white-50 mt-2">
                        La calidad de siempre, ahora online. Hacé tu pedido y retirá sin esperas.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Contacto</h5>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i> Av. Sabin 781, Resistencia</li>
                        <li class="mb-2"><i class="bi bi-whatsapp me-2"></i> 3625-159450</li>
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

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>