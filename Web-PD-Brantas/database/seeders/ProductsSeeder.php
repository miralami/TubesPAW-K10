<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name'        => 'Sepatu PDL Hitam',
                'description' => 'Sepatu PDL kulit hitam model tinggi anti slip.',
                'price'       => 245000,
                'stock'       => 20,
                'sold'        => 0,
                'category'    => 'TNI',
                'image'       => 'products/sepatu_pdl.jpg',
            ],
            [
                'name'        => 'Topi Polisi',
                'description' => 'Topi dinas polisi hitam dengan emblem logam.',
                'price'       => 99000,
                'stock'       => 15,
                'sold'        => 0,
                'category'    => 'Polisi',
                'image'       => 'products/topi_polisi.jpg',
            ],
            [
                'name'        => 'Topi TNI Baret',
                'description' => 'Baret hijau TNI AD bahan wol dengan emblem.',
                'price'       => 87000,
                'stock'       => 12,
                'sold'        => 0,
                'category'    => 'TNI',
                'image'       => 'products/topi_tni_baret.jpg',
            ],
            [
                'name'        => 'Topi TNI Loreng',
                'description' => 'Topi rimba loreng dengan tali dagu, bahan ripstop.',
                'price'       => 68000,
                'stock'       => 18,
                'sold'        => 0,
                'category'    => 'TNI',
                'image'       => 'products/topi_tni.jpg',
            ],
            [
                'name'        => 'Jas Hujan Ponco',
                'description' => 'Jas hujan ponco lebar, bisa untuk motor dan camping.',
                'price'       => 110000,
                'stock'       => 25,
                'sold'        => 0,
                'category'    => 'Aksesoris',
                'image'       => 'products/jas_hujan.jpg',
            ],
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}
