<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        $wishlists = [
            ['id' => 1, 'user_id' => 17, 'product_id' => 19, 'created_at' => '2026-01-04 17:11:35'],
            ['id' => 2, 'user_id' => 17, 'product_id' => 1, 'created_at' => '2026-01-04 17:11:58'],
        ];

        foreach ($wishlists as $wishlist) {
            Wishlist::create($wishlist);
        }
    }
}
