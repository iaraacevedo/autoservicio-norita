<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class SupermercadoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpieza de tablas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Producto::truncate();
        Categoria::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Categorías
        $categorias = [
            'Almacén',
            'Bebidas',
            'Frescos',
            'Limpieza',
            'Panadería',
            'Golosinas'
        ];

        foreach ($categorias as $nombreCat) {
            Categoria::create(['nombre' => $nombreCat]);
        }

        // 3. Productos con IMÁGENES SEGURAS (Placehold.co)
        // Usamos este servicio que genera la imagen con el texto del producto.
        // Formato: https://placehold.co/600x400/COLOR_FONDO/COLOR_TEXTO?text=NOMBRE_PRODUCTO

        $productos = [
            // --- ALMACÉN (Naranja) ---
            [
                'nombre' => 'Yerba Mate Playadito 1kg',
                'descripcion' => 'Yerba mate elaborada con palo, libre de gluten. Sabor suave.',
                'precio' => 4500.00,
                'categoria' => 'Almacén',
                'imagen_url' => 'https://placehold.co/400x300/orange/white?text=Yerba+Playadito',
            ],
            [
                'nombre' => 'Aceite Natura 1.5L',
                'descripcion' => 'Aceite puro de girasol, ideal para cocinar. Envase familiar.',
                'precio' => 2800.50,
                'categoria' => 'Almacén',
                'imagen_url' => 'https://placehold.co/400x300/orange/white?text=Aceite+Natura',
            ],
            [
                'nombre' => 'Arroz Gallo Oro 1kg',
                'descripcion' => 'Arroz parboil que no se pasa ni se pega.',
                'precio' => 1950.00,
                'categoria' => 'Almacén',
                'imagen_url' => 'https://placehold.co/400x300/orange/white?text=Arroz+Gallo',
            ],

            // --- BEBIDAS (Rojo/Negro) ---
            [
                'nombre' => 'Coca Cola 2.25L',
                'descripcion' => 'Sabor original, botella retornable.',
                'precio' => 3200.00,
                'categoria' => 'Bebidas',
                'imagen_url' => 'https://placehold.co/400x300/red/white?text=Coca+Cola',
            ],
            [
                'nombre' => 'Cerveza Quilmes 1L',
                'descripcion' => 'Cerveza rubia argentina, retornable.',
                'precio' => 2500.00,
                'categoria' => 'Bebidas',
                'imagen_url' => 'https://placehold.co/400x300/000000/white?text=Cerveza+Quilmes',
            ],
            [
                'nombre' => 'Agua Villavicencio 2L',
                'descripcion' => 'Agua mineral natural de manantial.',
                'precio' => 1200.00,
                'categoria' => 'Bebidas',
                'imagen_url' => 'https://placehold.co/400x300/0044cc/white?text=Agua+Mineral',
            ],

            // --- FRESCOS (Celeste/Blanco) ---
            [
                'nombre' => 'Leche La Serenísima 1L',
                'descripcion' => 'Leche entera ultrapasteurizada.',
                'precio' => 1600.00,
                'categoria' => 'Frescos',
                'imagen_url' => 'https://placehold.co/400x300/87CEEB/black?text=Leche+Entera',
            ],
            [
                'nombre' => 'Manteca La Paulina 200g',
                'descripcion' => 'Calidad extra para repostería.',
                'precio' => 2100.00,
                'categoria' => 'Frescos',
                'imagen_url' => 'https://placehold.co/400x300/87CEEB/black?text=Manteca',
            ],

            // --- LIMPIEZA (Verde) ---
            [
                'nombre' => 'Lavandina Ayudín 1L',
                'descripcion' => 'Máxima pureza, elimina el 99% de bacterias.',
                'precio' => 1400.00,
                'categoria' => 'Limpieza',
                'imagen_url' => 'https://placehold.co/400x300/green/white?text=Lavandina',
            ],
            [
                'nombre' => 'Detergente Magistral 500ml',
                'descripcion' => 'Rinde x4, aroma limón.',
                'precio' => 2200.00,
                'categoria' => 'Limpieza',
                'imagen_url' => 'https://placehold.co/400x300/green/white?text=Detergente',
            ],

            // --- PANADERÍA (Marrón) ---
            [
                'nombre' => 'Pan Lactal Bimbo 350g',
                'descripcion' => 'Pan blanco de mesa, tierno.',
                'precio' => 2800.00,
                'categoria' => 'Panadería',
                'imagen_url' => 'https://placehold.co/400x300/brown/white?text=Pan+Lactal',
            ],
            [
                'nombre' => 'Docena de Facturas',
                'descripcion' => 'Surtidas: Medialunas y vigilantes.',
                'precio' => 4500.00,
                'categoria' => 'Panadería',
                'imagen_url' => 'https://placehold.co/400x300/brown/white?text=Facturas',
            ],
        ];

        foreach ($productos as $prod) {
            Producto::create([
                'nombre' => $prod['nombre'],
                'descripcion' => $prod['descripcion'],
                'precio' => $prod['precio'],
                'categoria' => $prod['categoria'],
                'imagen_url' => $prod['imagen_url'],
                'stock' => 9999,
                'activo' => true
            ]);
        }
    }
}
