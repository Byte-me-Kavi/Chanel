<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $req)
    {
        $q = $req->get('q', '');
        // Logic moved to client-side
        return view('search', ['query' => $q]);
    }
}
