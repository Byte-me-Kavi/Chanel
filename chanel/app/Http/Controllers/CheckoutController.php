<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        // Admin users cannot checkout
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.index')->with('error', 'Admin users cannot place orders.');
        }

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = collect($cart)->sum('price');
        $taxRate = 0.10; // 10%
        $tax = $subtotal > 200 ? $subtotal * $taxRate : 0;
        $total = $subtotal + $tax;

        $deliveryMethods = [
            'Standard Shipping',
            'Express Shipping',
            'Same-Day or Next-Day Delivery',
            'In-Store Pickup (Click and Collect)',
        ];

        return view('checkout', compact('cart', 'subtotal', 'tax', 'total', 'deliveryMethods'));
    }

    /**
     * Process the order
     */
    public function store(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|string',
            'privacy' => 'required|accepted',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            $userId = Auth::check() ? Auth::id() : null;

            foreach ($cart as $item) {
                Order::create([
                    'user_id' => $userId,
                    'product_name' => $item['name'] ?? 'Unknown Product',
                    'price' => $item['price'] ?? 0,
                    'image' => $item['image'] ?? '',
                    'quantity' => $item['quantity'] ?? 1,
                    'order_status' => 'Order Placed',
                    'status' => 'Pending',
                    'wrapping_option' => $request->input('wrapping', 'The Essential'),
                    'gift_message' => $request->input('gift_message', ''),
                ]);
            }

            DB::commit();

            // Clear the cart
            session()->forget('cart');

            return redirect()->route('checkout.success');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Could not place order. Please try again.');
        }
    }

    /**
     * Display order success page
     */
    public function success()
    {
        return view('checkout-success');
    }
}
