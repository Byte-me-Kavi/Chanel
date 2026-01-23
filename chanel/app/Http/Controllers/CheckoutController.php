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
        // admins shouldn't be here
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.index')->with('error', 'Admin users cannot place orders.');
        }

        $cart = session()->get('cart', []);
        
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = collect($cart)->sum('price');
        
        // simple tax logic
        $tax = $subtotal > 200 ? $subtotal * 0.10 : 0;
        $total = $subtotal + $tax;

        $deliveryMethods = [
            'Standard Shipping',
            'Express Shipping',
            'Same-Day or Next-Day Delivery',
            'In-Store Pickup (Click and Collect)',
        ];

        return view('checkout', compact('cart', 'subtotal', 'tax', 'total', 'deliveryMethods'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'delivery_method' => 'required|string',
            'privacy' => 'required|accepted',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Create an order for each item
        foreach ($cart as $item) {
            Order::create([
                'user_id' => Auth::id(),
                'product_name' => $item['name'] ?? 'Item',
                'price' => $item['price'] ?? 0,
                'image' => $item['image'] ?? '',
                'quantity' => $item['quantity'] ?? 1,
                'order_status' => 'Order Placed',
                'status' => 'Pending',
                'wrapping_option' => $req->has('wrapping') ? 1 : 0,
                'gift_message' => $req->input('gift_message', ''),
            ]);
        }

        // clear cart after success
        session()->forget('cart');

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('checkout-success');
    }
}
