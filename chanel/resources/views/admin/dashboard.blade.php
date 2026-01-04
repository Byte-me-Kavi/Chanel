@extends('layouts.frontend')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 text-sm">Logout</button>
        </form>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
    @endif

    <!-- Tabs -->
    <div class="flex gap-4 mb-8 border-b border-gray-300">
        <a href="{{ route('admin.index', ['tab' => 'deliveries']) }}" 
           class="pb-3 px-4 {{ $tab === 'deliveries' ? 'border-b-2 border-black font-bold' : 'text-gray-500' }}">
            Deliveries
        </a>
        <a href="{{ route('admin.index', ['tab' => 'products']) }}" 
           class="pb-3 px-4 {{ $tab === 'products' ? 'border-b-2 border-black font-bold' : 'text-gray-500' }}">
            Products
        </a>
        <a href="{{ route('admin.index', ['tab' => 'users']) }}" 
           class="pb-3 px-4 {{ $tab === 'users' ? 'border-b-2 border-black font-bold' : 'text-gray-500' }}">
            Users
        </a>
        <a href="{{ route('admin.index', ['tab' => 'orders']) }}" 
           class="pb-3 px-4 {{ $tab === 'orders' ? 'border-b-2 border-black font-bold' : 'text-gray-500' }}">
            Orders
        </a>
    </div>

    <!-- DELIVERIES TAB -->
    @if($tab === 'deliveries')
    <div>
        <h2 class="text-xl font-bold mb-4">Manage Deliveries</h2>
        
        <!-- Status Filter -->
        <div class="mb-4">
            <select onchange="window.location.href='{{ route('admin.index') }}?tab=deliveries&status='+this.value" class="border p-2 rounded">
                <option value="All" {{ $statusFilter === 'All' ? 'selected' : '' }}>All Statuses</option>
                <option value="On Progress" {{ $statusFilter === 'On Progress' ? 'selected' : '' }}>On Progress</option>
                <option value="Successful" {{ $statusFilter === 'Successful' ? 'selected' : '' }}>Successful</option>
                <option value="On Hold" {{ $statusFilter === 'On Hold' ? 'selected' : '' }}>On Hold</option>
                <option value="Canceled" {{ $statusFilter === 'Canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
        </div>

        <!-- Add Delivery Form -->
        <form action="{{ route('admin.delivery.store') }}" method="POST" class="bg-gray-50 p-4 rounded mb-6">
            @csrf
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <input type="text" name="customer_name" placeholder="Customer Name" required class="border p-2 rounded">
                <input type="text" name="address" placeholder="Address" required class="border p-2 rounded">
                <input type="text" name="product" placeholder="Product" required class="border p-2 rounded">
                <input type="number" name="quantity" placeholder="Qty" value="1" min="1" required class="border p-2 rounded">
                <select name="status" class="border p-2 rounded">
                    <option value="On Progress">On Progress</option>
                    <option value="Successful">Successful</option>
                    <option value="On Hold">On Hold</option>
                    <option value="Canceled">Canceled</option>
                </select>
            </div>
            <button type="submit" class="mt-4 bg-black text-white px-6 py-2 rounded hover:bg-gray-800">Add Delivery</button>
        </form>

        <!-- Deliveries Table -->
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">Order #</th>
                    <th class="border p-2 text-left">Customer</th>
                    <th class="border p-2 text-left">Product</th>
                    <th class="border p-2 text-left">Qty</th>
                    <th class="border p-2 text-left">Status</th>
                    <th class="border p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveries as $delivery)
                <tr>
                    <td class="border p-2">{{ $delivery->order_number }}</td>
                    <td class="border p-2">{{ $delivery->customer_name }}</td>
                    <td class="border p-2">{{ $delivery->product }}</td>
                    <td class="border p-2">{{ $delivery->quantity }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-xs 
                            {{ $delivery->status === 'Successful' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $delivery->status === 'On Progress' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $delivery->status === 'On Hold' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $delivery->status === 'Canceled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $delivery->status }}
                        </span>
                    </td>
                    <td class="border p-2">
                        <a href="{{ route('admin.delivery.delete', $delivery->id) }}" onclick="return confirm('Delete this delivery?')" class="text-red-600 hover:underline">Delete</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="border p-4 text-center text-gray-500">No deliveries found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <!-- PRODUCTS TAB -->
    @if($tab === 'products')
    <div>
        <h2 class="text-xl font-bold mb-4">Manage Products</h2>
        
        <!-- Add Product Form -->
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-4 rounded mb-6">
            @csrf
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <input type="text" name="name" placeholder="Product Name" required class="border p-2 rounded">
                <input type="number" name="price" placeholder="Price" step="0.01" required class="border p-2 rounded">
                <input type="text" name="description" placeholder="Description" class="border p-2 rounded">
                <input type="file" name="image" accept="image/*" class="border p-2 rounded">
            </div>
            <button type="submit" class="mt-4 bg-black text-white px-6 py-2 rounded hover:bg-gray-800">Add Product</button>
        </form>

        <!-- Products Table -->
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">Image</th>
                    <th class="border p-2 text-left">Name</th>
                    <th class="border p-2 text-left">Price</th>
                    <th class="border p-2 text-left">Description</th>
                    <th class="border p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="border p-2"><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover"></td>
                    <td class="border p-2">{{ $product->name }}</td>
                    <td class="border p-2">${{ number_format($product->price, 2) }}</td>
                    <td class="border p-2">{{ Str::limit($product->description, 50) }}</td>
                    <td class="border p-2">
                        <a href="{{ route('admin.product.delete', $product->id) }}" onclick="return confirm('Delete this product?')" class="text-red-600 hover:underline">Delete</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="border p-4 text-center text-gray-500">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <!-- USERS TAB -->
    @if($tab === 'users')
    <div>
        <h2 class="text-xl font-bold mb-4">Manage Users</h2>
        
        <!-- Add User Form -->
        <form action="{{ route('admin.user.store') }}" method="POST" class="bg-gray-50 p-4 rounded mb-6">
            @csrf
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <input type="text" name="name" placeholder="Name" required class="border p-2 rounded">
                <input type="email" name="email" placeholder="Email" required class="border p-2 rounded">
                <input type="password" name="password" placeholder="Password" required class="border p-2 rounded">
            </div>
            <button type="submit" class="mt-4 bg-black text-white px-6 py-2 rounded hover:bg-gray-800">Add User</button>
        </form>

        <!-- Users Table -->
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">ID</th>
                    <th class="border p-2 text-left">Name</th>
                    <th class="border p-2 text-left">Email</th>
                    <th class="border p-2 text-left">Created</th>
                    <th class="border p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="border p-2">{{ $user->id }}</td>
                    <td class="border p-2">{{ $user->name }}</td>
                    <td class="border p-2">{{ $user->email }}</td>
                    <td class="border p-2">{{ $user->created_at ? $user->created_at->format('m/d/Y') : 'N/A' }}</td>
                    <td class="border p-2">
                        <a href="{{ route('admin.user.delete', $user->id) }}" onclick="return confirm('Delete this user?')" class="text-red-600 hover:underline">Delete</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="border p-4 text-center text-gray-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <!-- ORDERS TAB -->
    @if($tab === 'orders')
    <div>
        <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
        
        <!-- Orders Table -->
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-left">ID</th>
                    <th class="border p-2 text-left">Product</th>
                    <th class="border p-2 text-left">Price</th>
                    <th class="border p-2 text-left">Qty</th>
                    <th class="border p-2 text-left">Status</th>
                    <th class="border p-2 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="border p-2">{{ $order->id }}</td>
                    <td class="border p-2">{{ $order->product_name }}</td>
                    <td class="border p-2">${{ number_format($order->price, 2) }}</td>
                    <td class="border p-2">{{ $order->quantity }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
                            {{ $order->order_status }}
                        </span>
                    </td>
                    <td class="border p-2">{{ $order->created_at ? $order->created_at->format('m/d/Y') : 'N/A' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="border p-4 text-center text-gray-500">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
