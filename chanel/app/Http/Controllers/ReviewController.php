<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $req, $pId)
    {
        $req->validate([
            'author_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string',
        ]);

        Product::findOrFail($pId);

        Review::create([
            'product_id' => $pId,
            'author_name' => $req->author_name,
            'rating' => $req->rating,
            'review_text' => $req->review_text,
        ]);

        return redirect()->route('product.show', $pId)
            ->with('review_success', 'Thank you! Your review has been submitted.');
    }
}
