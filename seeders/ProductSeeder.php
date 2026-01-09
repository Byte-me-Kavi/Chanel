<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Chance',
                'description' => 'New Hair Mist',
                'image' => 'uploads/1758347744_chance_eau_tendre.webp',
                'price' => 82.00,
                'image_url' => '',
                'created_at' => '2025-09-20 05:55:44',
            ],
            [
                'id' => 19,
                'name' => 'chanel',
                'description' => 'New Body Spray lnn',
                'image' => 'uploads/chance.webp',
                'price' => 67.00,
                'image_url' => '',
                'created_at' => '2025-09-19 05:04:11',
            ],
            [
                'id' => 26,
                'name' => 'ALLURE HOMME SPORT',
                'description' => '',
                'image' => 'uploads/neww6.webp',
                'price' => 987.00,
                'image_url' => '',
                'created_at' => '2025-09-19 07:25:27',
            ],
            [
                'id' => 34,
                'name' => 'Teena',
                'description' => 'NEW BRAND',
                'image' => 'uploads/1758298801_coco_manem.webp',
                'price' => 377.90,
                'image_url' => '',
                'created_at' => '2025-09-19 16:20:01',
            ],
            [
                'id' => 36,
                'name' => 'Chanel Makeup',
                'description' => '',
                'image' => 'uploads/1758299922_neww3.webp',
                'price' => 777.99,
                'image_url' => '',
                'created_at' => '2025-09-19 16:38:42',
            ],
            [
                'id' => 41,
                'name' => 'Test',
                'description' => 'test product',
                'image' => 'uploads/vani.webp', // Found vani.webp in uploads folder
                'price' => 100.00,
                'image_url' => '',
                'created_at' => '2026-01-04 16:33:44',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
