@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-black text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">Iniciar Sesión</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg">
                                Ingresar
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a class="text-muted text-decoration-none" href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection