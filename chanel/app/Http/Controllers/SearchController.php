<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $req)
    {
        $q = $req->get('q', '');
        $products = collect();

        if (!empty($q)) {
            $products = Product::where('name', 'LIKE', "%{$q}%")
                ->orWhere('description', 'LIKE', "%{$q}%")
                ->get();
        }

        return view('search', ['products' => $products, 'query' => $q]);
    }
}
