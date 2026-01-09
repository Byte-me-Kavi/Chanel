<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            ['id' => 1, 'product_id' => 1, 'author_name' => 'teena', 'rating' => 5, 'review_text' => 'aa', 'created_at' => '2025-09-21 07:44:58'],
            ['id' => 2, 'product_id' => 1, 'author_name' => 'teena', 'rating' => 5, 'review_text' => 'The product quality is consistently outstanding, exceeding my expectations every time.', 'created_at' => '2025-09-21 10:39:35'],
            ['id' => 3, 'product_id' => 1, 'author_name' => 'Leo', 'rating' => 2, 'review_text' => 'Efficiency and punctuality are hallmarks of their service.', 'created_at' => '2025-09-21 10:55:05'],
            ['id' => 4, 'product_id' => 1, 'author_name' => 'teena', 'rating' => 3, 'review_text' => 'great', 'created_at' => '2025-09-21 15:03:53'],
            ['id' => 5, 'product_id' => 1, 'author_name' => 'Chris', 'rating' => 5, 'review_text' => 'The product quality is consistently outstanding, exceeding my expectations every time.', 'created_at' => '2025-09-21 15:13:24'],
            ['id' => 6, 'product_id' => 1, 'author_name' => 'Jennie', 'rating' => 5, 'review_text' => 'dfgfdhgfxmgh,fghnm', 'created_at' => '2025-09-22 04:08:55'],
            ['id' => 7, 'product_id' => 26, 'author_name' => 'kavi', 'rating' => 5, 'review_text' => 'nice', 'created_at' => '2026-01-04 16:26:28'],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
