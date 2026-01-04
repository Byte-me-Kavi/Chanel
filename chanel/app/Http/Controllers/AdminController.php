<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with tab support
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'deliveries');
        $statusFilter = $request->get('status', 'All');

        $deliveries = Delivery::orderBy('created_at', 'desc')->get();
        $products = Product::all();
        $users = User::all();
        $orders = Order::orderBy('created_at', 'desc')->get();

        // Filter deliveries by status if needed
        if ($statusFilter !== 'All') {
            $deliveries = Delivery::where('status', $statusFilter)->orderBy('created_at', 'desc')->get();
        }

        return view('admin.dashboard', compact('tab', 'deliveries', 'products', 'users', 'orders', 'statusFilter'));
    }

    // ===== DELIVERY CRUD =====
    
    public function storeDelivery(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        Delivery::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'product' => $request->product,
            'item_name' => $request->product,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.index', ['tab' => 'deliveries'])->with('success', 'Delivery added successfully.');
    }

    public function updateDelivery(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $delivery->update($request->only(['customer_name', 'address', 'product', 'quantity', 'status']));

        return redirect()->route('admin.index', ['tab' => 'deliveries'])->with('success', 'Delivery updated successfully.');
    }

    public function deleteDelivery($id)
    {
        Delivery::findOrFail($id)->delete();
        return redirect()->route('admin.index', ['tab' => 'deliveries'])->with('success', 'Delivery deleted successfully.');
    }

    // ===== PRODUCT CRUD =====
    
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = 'uploads/' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'), $request->file('image')->getClientOriginalName());
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description ?? '',
            'image' => $imagePath,
            'image_url' => '',
        ]);

        return redirect()->route('admin.index', ['tab' => 'products'])->with('success', 'Product added successfully.');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'price', 'description']);
        
        if ($request->hasFile('image')) {
            $imagePath = 'uploads/' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'), $request->file('image')->getClientOriginalName());
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('admin.index', ['tab' => 'products'])->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.index', ['tab' => 'products'])->with('success', 'Product deleted successfully.');
    }

    // ===== USER CRUD =====
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->name,
            'is_active' => 1,
        ]);

        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'User added successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $data = $request->only(['name', 'email']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'User deleted successfully.');
    }
}
