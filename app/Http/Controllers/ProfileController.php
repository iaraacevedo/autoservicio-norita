<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.editar', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */ // <--- ESTA LÍNEA MÁGICA ARREGLA EL ERROR
        $user = Auth::user();

        // 1. Validaciones
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Asignar nuevos valores
        $user->name = $request->name;
        $user->email = $request->email;

        // Solo asignamos si el campo existe en la base de datos (por seguridad)
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;

        // 3. Cambio de contraseña (solo si escribió algo)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 4. Guardar
        $user->save();

        return redirect()->back()->with('success', '¡Perfil actualizado correctamente!');
    }
}
