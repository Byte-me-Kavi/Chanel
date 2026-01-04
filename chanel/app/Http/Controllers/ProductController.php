<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the product listing page.
     */
    public function index()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    /**
     * Display the exclusives page.
     */
    public function exclusives()
    {
        $products = Product::all();
        return view('exclusives', compact('products'));
    }

    /**
     * Display a single product detail page.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('id', '!=', $id)->take(4)->get();
        
        return view('product-details', compact('product', 'relatedProducts'));
    }
}
