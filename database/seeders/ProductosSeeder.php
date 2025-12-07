<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Yerba Mate 1kg',
                'descripcion' => 'Yerba mate tradicional, paquete de 1kg.',
                'precio' => 3500.00,
                'stock' => 50,
                'categoria' => 'Almacen',
                'imagen_url' => 'https://clickandfoods.com/cdn/shop/files/YerbaMateVerdeflorHierbasSerranas500g_YerbaArgentinaconHierbasNaturales.png?v=1756919527',
            ],
            [
                'nombre' => 'Aceite de Girasol 900ml',
                'descripcion' => 'Aceite puro de girasol, ideal para cocinar.',
                'precio' => 1800.50,
                'stock' => 30,
                'categoria' => 'Almacen',
                'imagen_url' => 'https://statics.dinoonline.com.ar/imagenes/full_600x600_ma/2320094_f.jpg',
            ],
            [
                'nombre' => 'Coca Cola 2.25L',
                'descripcion' => 'Gaseosa sabor cola, botella retornable.',
                'precio' => 2500.00,
                'stock' => 100,
                'categoria' => 'Bebidas',
                'imagen_url' => 'https://static.wixstatic.com/media/d2b1c5_c18cdc43739744e382df6287531c066a~mv2.jpg/v1/fill/w_480,h_400,al_c,q_80,usm_0.66_1.00_0.01,enc_avif,quality_auto/d2b1c5_c18cdc43739744e382df6287531c066a~mv2.jpg',
            ],
            [
                'nombre' => 'Fideos Tallarines 500g',
                'descripcion' => 'Fideos secos tipo tallarín.',
                'precio' => 1200.00,
                'stock' => 40,
                'categoria' => 'Pastas',
                'imagen_url' => 'https://carrefourar.vtexassets.com/arquivos/ids/408418/7790070336316_02.jpg?v=638343782761330000',
            ],
            [
                'nombre' => 'Arroz Largo Fino 1kg',
                'descripcion' => 'Arroz blanco largo fino, no se pasa.',
                'precio' => 1600.00,
                'stock' => 60,
                'categoria' => 'Almacen',
                'imagen_url' => 'https://acdn-us.mitiendanube.com/stores/313/507/products/ala-84643f0db349d8406317424088908806-480-0.webp',
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
