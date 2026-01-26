<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Data will be fetched via API in the view
        return view('product');
    }

    public function exclusives()
    {
        // Data via API
        return view('exclusives');
    }

    public function show($id)
    {
        // Data fetched via API in view
        return view('product-details', ['id' => $id]);
    }
}
