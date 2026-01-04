<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum('price');
        
        return view('cart', compact('cart', 'total'));
    }

    /**
     * Add a product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $cart = session()->get('cart', []);
        
        $cart[] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
        ];
        
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Product added to bag!');
    }

    /**
     * Remove an item from cart
     */
    public function remove($index)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // Reindex array
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Item removed from bag.');
    }

    /**
     * Clear the entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
