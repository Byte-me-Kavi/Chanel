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
    // Main dashboard view
    public function index(Request $req)
    {
        // default tab is deliveries
        $currentTab = $req->get('tab', 'deliveries'); 
        $status = $req->get('status', 'All');

        $deliveries = Delivery::orderBy('created_at', 'desc')->get();
        $products = Product::all();
        $users = User::all();
        $orders = Order::orderBy('created_at', 'desc')->get();

        // if we need to filter by status
        if ($status !== 'All') {
            $deliveries = Delivery::where('status', $status)->orderBy('created_at', 'desc')->get();
        }

        return view('admin.dashboard', [
            'tab' => $currentTab,
            'deliveries' => $deliveries,
            'products' => $products,
            'users' => $users,
            'orders' => $orders,
            'statusFilter' => $status
        ]);
    }

    // Delivery functions
    
    public function storeDelivery(Request $req)
    {
        $req->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        Delivery::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $req->customer_name,
            'address' => $req->address,
            'product' => $req->product,
            'item_name' => $req->product, // just copying product name here
            'quantity' => $req->quantity,
            'status' => $req->status,
        ]);

        return redirect()->route('admin.index', ['tab' => 'deliveries'])->with('success', 'Delivery added successfully.');
    }

    public function updateDelivery(Request $req, $id)
    {
        $item = Delivery::findOrFail($id);
        
        $req->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $item->update($req->only(['customer_name', 'address', 'product', 'quantity', 'status']));

        return redirect()->route('admin.index', ['tab' => 'deliveries'])->with('success', 'Delivery updated successfully.');
    }

    public function deleteDelivery($id)
    {
        $d = Delivery::findOrFail($id);
        $d->delete();
        return redirect()->route('admin.index', ['tab' => 'deliveries'])->with('success', 'Delivery deleted successfully.');
    }

    // Product management
    
    public function storeProduct(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $img = '';
        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $img = 'uploads/' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file->getClientOriginalName());
        }

        Product::create([
            'name' => $req->name,
            'price' => $req->price,
            'description' => $req->description ?? '',
            'image' => $img,
            'image_url' => '',
        ]);

        return redirect()->route('admin.index', ['tab' => 'products'])->with('success', 'Product added successfully.');
    }

    public function updateProduct(Request $req, $id)
    {
        $prod = Product::findOrFail($id);
        
        $req->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $data = $req->only(['name', 'price', 'description']);
        
        if ($req->hasFile('image')) {
            $f = $req->file('image');
            $path = 'uploads/' . $f->getClientOriginalName();
            $f->move(public_path('uploads'), $f->getClientOriginalName());
            $data['image'] = $path;
        }

        $prod->update($data);

        return redirect()->route('admin.index', ['tab' => 'products'])->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.index', ['tab' => 'products'])->with('success', 'Product deleted successfully.');
    }

    // Users
    
    public function storeUser(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'username' => $req->name,
            'is_active' => 1,
        ]);

        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'User added successfully.');
    }

    public function updateUser(Request $req, $id)
    {
        $u = User::findOrFail($id);
        
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $data = $req->only(['name', 'email']);
        
        if ($req->filled('password')) {
            $data['password'] = Hash::make($req->password);
        }

        $u->update($data);

        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'User deleted successfully.');
    }
}
