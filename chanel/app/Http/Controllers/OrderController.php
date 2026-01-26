<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // My Orders page
    public function index()
    {
        // Data fetched via API
        return view('orders.index');
    }

    // tracking page
    public function track($id)
    {
        // Data fetched via API
        return view('orders.track', ['id' => $id]);
    }

    // api for status
    public function status($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'status' => $order->order_status,
            'updated_at' => $order->created_at ? $order->created_at->format('m/d/Y H:i') : 'N/A',
        ]);
    }
}
