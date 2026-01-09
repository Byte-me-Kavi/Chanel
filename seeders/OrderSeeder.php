<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::truncate();

        // Sample of orders from the huge list in SQL dump
        // Mapping important ones and recent ones
        $orders = [
            ['id' => 73, 'user_id' => null, 'product_name' => 'Classic Handbag', 'price' => 1250.50, 'image' => 'uploads/handbag.jpg', 'order_status' => 'Completed', 'status' => 'active', 'quantity' => 1, 'created_at' => '2025-09-19 07:23:34'],
            ['id' => 90, 'user_id' => null, 'product_name' => 'BLEU DE CHANEL', 'price' => 95.00, 'image' => '/Website/img/deodrant.webp', 'order_status' => 'Order Placed', 'status' => 'Pending', 'quantity' => 1, 'created_at' => '2026-01-04 13:10:48'],
            ['id' => 91, 'user_id' => null, 'product_name' => 'chanel', 'price' => 67.00, 'image' => 'uploads/chance.webp', 'order_status' => 'Order Placed', 'status' => 'Pending', 'quantity' => 1, 'created_at' => '2026-01-04 16:16:17'],
            ['id' => 92, 'user_id' => null, 'product_name' => 'ALLURE HOMME SPORT', 'price' => 987.00, 'image' => 'uploads/neww6.webp', 'order_status' => 'Order Placed', 'status' => 'Pending', 'quantity' => 1, 'created_at' => '2026-01-04 16:16:17'],
            ['id' => 94, 'user_id' => 17, 'product_name' => 'chanel', 'price' => 67.00, 'image' => 'uploads/chance.webp', 'order_status' => 'Order Placed', 'status' => 'Pending', 'quantity' => 1, 'created_at' => '2026-01-04 16:51:08'],
            ['id' => 95, 'user_id' => 18, 'product_name' => 'chanel', 'price' => 67.00, 'image' => 'uploads/chance.webp', 'order_status' => 'Order Placed', 'status' => 'Pending', 'quantity' => 1, 'created_at' => '2026-01-04 17:33:51'],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
