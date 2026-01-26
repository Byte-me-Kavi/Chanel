<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function store(Request $req)
    {
        // Should use API
        return response()->json(['message' => 'Please use API endpoint'], 400);
    }

    public function success()
    {
        return view('checkout-success');
    }
}
