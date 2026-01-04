<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'author_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string',
        ]);

        // Verify product exists
        Product::findOrFail($productId);

        Review::create([
            'product_id' => $productId,
            'author_name' => $request->author_name,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        return redirect()->route('product.show', $productId)
            ->with('review_success', 'Thank you! Your review has been submitted.');
    }
}
