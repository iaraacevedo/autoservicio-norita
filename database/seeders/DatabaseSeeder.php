<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $this->call([
            // 1. Primero creamos al Admin (Julio) y Clientes de prueba
            AdminUserSeeder::class,

            // 2. Luego cargamos las Categorías y Productos
            SupermercadoSeeder::class,
        ]);
    }
}
