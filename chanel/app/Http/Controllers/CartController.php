<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // show cart
    public function index()
    {
        // Cart managed by JS/LocalStorage
        return view('cart');
    }

    // add item
    public function add(Request $req)
    {
        $req->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $prod = Product::findOrFail($req->product_id);
        
        $cart = session()->get('cart', []);
        
        $cart[] = [
            'id' => $prod->id,
            'name' => $prod->name,
            'price' => $prod->price,
            'image' => $prod->image,
        ];
        
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Product added to bag!');
    }

    public function remove($index)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // fix keys
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Item removed from bag.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
