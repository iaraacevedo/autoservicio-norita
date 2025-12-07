<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos el usuario Administrador (Julio)
        User::create([
            'name' => 'Julio Miño', // Nombre real del tutor
            'email' => 'admin@norita.com', // Correo de acceso
            'password' => Hash::make('admin123'), // Contraseña
            'rol' => 'admin', // ¡Muy importante! Esto le da los permisos
            'telefono' => '3624000000',
            'direccion' => 'Av. Sabin 781'
        ]);

        // Opcional: Creamos un cliente de prueba para testear compras
        User::create([
            'name' => 'Cliente Prueba',
            'email' => 'cliente@test.com',
            'password' => Hash::make('12345678'),
            'rol' => 'cliente',
        ]);
    }
}
