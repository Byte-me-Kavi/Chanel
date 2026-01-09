<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Delivery;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        $deliveries = [
            ['id' => 7, 'order_number' => 'ORD-1758303013-2576', 'item_name' => '', 'item_category' => 'NULL', 'delivery_code' => 'NULL', 'courier_id' => 'NULL', 'status' => 'Canceled', 'customer_name' => 'razik', 'address' => 'sigiriya', 'product' => 'Chanel Perfume', 'quantity' => 1, 'created_at' => '2025-09-19 17:30:13'],
            ['id' => 11, 'order_number' => 'ORD-1758303536', 'item_name' => '', 'item_category' => 'NULL', 'delivery_code' => 'NULL', 'courier_id' => 'NULL', 'status' => 'Refunded', 'customer_name' => 'sha', 'address' => 'hirassagala', 'product' => 'chanel', 'quantity' => 1, 'created_at' => '2025-09-19 17:38:56'],
            ['id' => 16, 'order_number' => 'ORD-1758304194', 'item_name' => '', 'item_category' => 'NULL', 'delivery_code' => 'NULL', 'courier_id' => 'NULL', 'status' => 'On Hold', 'customer_name' => 'Shabeena', 'address' => '408/16/5 Hirrasagala Bowalawaththa Kandy', 'product' => 'Chanel Perfume', 'quantity' => 1, 'created_at' => '2025-09-19 17:49:54'],
            ['id' => 17, 'order_number' => 'ORD-1758304207', 'item_name' => '', 'item_category' => 'NULL', 'delivery_code' => 'NULL', 'courier_id' => 'NULL', 'status' => 'Canceled', 'customer_name' => 'Shabeena', 'address' => '408/16/5 Hirrasagala Bowalawaththa Kandy', 'product' => 'Chanel Perfume', 'quantity' => 1, 'created_at' => '2025-09-19 17:50:07'],
            ['id' => 19, 'order_number' => 'ORD-1758347646', 'item_name' => '', 'item_category' => 'NULL', 'delivery_code' => 'NULL', 'courier_id' => 'NULL', 'status' => 'Successful', 'customer_name' => 'Teena', 'address' => '67/34/9, Kandy', 'product' => 'Chanel Perfume', 'quantity' => 4, 'created_at' => '2025-09-20 05:54:06'],
            ['id' => 21, 'order_number' => 'ORD-1758465918', 'item_name' => '', 'item_category' => 'NULL', 'delivery_code' => 'NULL', 'courier_id' => 'NULL', 'status' => 'Refunded', 'customer_name' => 'Leo', 'address' => '408/16/5 Hirrasagala Bowalawaththa Kandy', 'product' => 'CHANCE EAU TENDRE', 'quantity' => 8, 'created_at' => '2025-09-21 14:45:18'],
        ];

        foreach ($deliveries as $delivery) {
            Delivery::create($delivery);
        }
    }
}
