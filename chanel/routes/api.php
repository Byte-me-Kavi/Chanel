<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

// Public API Routes

// Get Products
Route::get('/products', function (Request $request) {
    $query = Product::query();
    
    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    return response()->json([
        'success' => true,
        'data' => $query->get()
    ]);
});

Route::post('/products/{id}/reviews', function (Request $request, $id) {
    $request->validate([
        'author_name' => 'required|string|max:100',
        'rating' => 'required|integer|min:1|max:5',
        'review_text' => 'required|string',
    ]);

    $product = Product::find($id);
    if(!$product) return response()->json(['message' => 'Product not found'], 404);

    $review = \App\Models\Review::create([
        'product_id' => $id,
        'author_name' => $request->author_name,
        'rating' => $request->rating,
        'review_text' => $request->review_text,
    ]);

    return response()->json(['success' => true, 'data' => $review], 201);
});

// Route::get('/products/exclusives') removed as it is identical to /products

Route::get('/products/{id}', function ($id) {
    $product = Product::with('reviews')->find($id);
    
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }
    
    $related = Product::where('id', '!=', $id)->take(4)->get();
    
    return response()->json([
        'success' => true,
        'data' => $product,
        'related' => $related
    ]);
});

// Authenticated API Routes
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Wishlist Operations
    Route::get('/wishlist', function () {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json(['success' => true, 'data' => $wishlist]);
    });

    Route::post('/wishlist', function (Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already in wishlist'], 409);
        }

        $item = Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Added to wishlist', 'data' => $item], 201);
    });

    Route::delete('/wishlist/{id}', function ($id) {
        $deleted = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        if ($deleted) {
             return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
        }
        
        $deletedByProduct = Wishlist::where('product_id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        if ($deletedByProduct) {
             return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
        }

        return response()->json(['message' => 'Item not found'], 404);
    });

    // Orders & Checkout
    Route::get('/orders', function () {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $orders]);
    });

    Route::get('/orders/{id}', function ($id) {
        $order = Order::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $order]);
    });

    // Checkout Logic
    Route::post('/checkout', function (Request $request) {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
            'delivery_method' => 'required|string',
        ]);

        $createdOrders = [];

        foreach ($request->items as $item) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'product_name' => $item['name'],
                'price' => $item['price'],
                'image' => $item['image'] ?? null,
                'quantity' => $item['quantity'],
                'order_status' => 'Order Placed',
                'status' => 'Pending',
                'wrapping_option' => $request->boolean('wrapping') ? 1 : 0,
                'gift_message' => $request->input('gift_message', ''),
            ]);
            $createdOrders[] = $order;
        }

        return response()->json([
            'success' => true, 
            'message' => 'Order placed successfully', 
            'orders' => $createdOrders
        ], 201);
    });
});

// Admin API Routes
Route::middleware(['auth:sanctum', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {

    Route::get('/deliveries', function () {
        return response()->json(['success' => true, 'data' => Delivery::all()]);
    });

    Route::post('/deliveries', function (Request $request) {
        $request->validate([
            'customer_name' => 'required|string',
            'address' => 'required|string',
            'product' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $delivery = Delivery::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'product' => $request->product,
            'item_name' => $request->product,
            'item_category' => $request->item_category ?? 'General',
            'delivery_code' => 'DEL-' . strtoupper(uniqid()),
            'courier_id' => '',
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'data' => $delivery], 201);
    });

    Route::put('/deliveries/{id}', function (Request $request, $id) {
        $delivery = Delivery::findOrFail($id);
        $delivery->update($request->all());
        return response()->json(['success' => true, 'data' => $delivery]);
    });

    Route::delete('/deliveries/{id}', function ($id) {
        Delivery::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Deleted']);
    });

    Route::post('/products', function (Request $request) {
        $product = Product::create($request->all());
        return response()->json(['success' => true, 'data' => $product], 201);
    });
});
