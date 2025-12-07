@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-black text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">Crear Cuenta</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg">
                                Registrarse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection