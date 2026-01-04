@extends('layouts.frontend')

@section('content')
<div class="max-w-5xl mx-auto my-12 px-4">
    <h1 class="text-3xl font-light tracking-widest text-center mb-8">My Orders</h1>

    @if($orders->count() > 0)
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-3 text-left">Order ID</th>
                <th class="border p-3 text-left">Product</th>
                <th class="border p-3 text-left">Price</th>
                <th class="border p-3 text-left">Status</th>
                <th class="border p-3 text-left">Date</th>
                <th class="border p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td class="border p-3">#{{ $order->id }}</td>
                <td class="border p-3">
                    <div class="flex items-center gap-3">
                        @if($order->image)
                        <img src="{{ asset($order->image) }}" alt="{{ $order->product_name }}" class="w-12 h-12 object-cover">
                        @endif
                        <span>{{ $order->product_name }}</span>
                    </div>
                </td>
                <td class="border p-3">${{ number_format($order->price, 2) }}</td>
                <td class="border p-3">
                    <span class="px-2 py-1 rounded text-xs 
                        {{ $order->order_status === 'Delivered' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $order->order_status === 'Order Placed' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $order->order_status === 'Shipped' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->order_status === 'Pending' ? 'bg-gray-100 text-gray-800' : '' }}">
                        {{ $order->order_status }}
                    </span>
                </td>
                <td class="border p-3">{{ $order->created_at ? $order->created_at->format('m/d/Y') : 'N/A' }}</td>
                <td class="border p-3">
                    <a href="{{ route('orders.track', $order->id) }}" class="text-black underline hover:no-underline">Track Order</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">You have no orders yet.</p>
        <a href="{{ route('product') }}" class="inline-block mt-4 bg-black text-white py-3 px-8 uppercase tracking-wider hover:bg-gray-800">Start Shopping</a>
    </div>
    @endif
</div>
@endsection
