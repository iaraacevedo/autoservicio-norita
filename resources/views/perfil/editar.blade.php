@extends('layouts.plantilla')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-black text-white">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-person-gear me-2"></i> Editar Mi Perfil</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Teléfono / WhatsApp</label>
                                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}" placeholder="Ej: 3624...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Dirección</label>
                                <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $user->direccion) }}" placeholder="Para envíos">
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">Cambiar Contraseña <small class="text-muted fw-normal fs-6">(Dejar en blanco para no cambiar)</small></h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Repetir Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-dark btn-lg">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection