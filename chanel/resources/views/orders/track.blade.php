@extends('layouts.frontend')

@section('content')
<div class="px-4 mx-auto my-12 max-w-3xl">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-light uppercase tracking-widest">Track Order</h1>
        <a href="{{ route('orders.index') }}" class="text-sm underline hover:no-underline">Back to Orders</a>
    </div>

    <!-- ID passed from controller -->
    <script>
        const orderId = {{ $id }};
    </script>

    <div id="loading" class="text-center py-12 text-gray-500">Loading tracking info...</div>
    
    <div id="track-content" class="hidden border border-gray-200 p-8 rounded bg-gray-50">
        <div class="text-center mb-8">
            <h2 id="t-order-num" class="text-xl font-bold uppercase tracking-wider"></h2>
            <p id="t-status" class="mt-2 text-lg text-emerald-600 font-medium"></p>
        </div>

        <div class="relative flex items-center justify-between mb-8">
            <div class="absolute left-0 top-1/2 w-full h-1 bg-gray-200 -z-10"></div>
            <!-- Simple Progress Bar Mockup -->
            <div class="bg-black text-white w-8 h-8 rounded-full flex items-center justify-center text-xs">1</div>
            <div class="bg-black text-white w-8 h-8 rounded-full flex items-center justify-center text-xs">2</div>
            <div class="bg-gray-200 text-gray-500 w-8 h-8 rounded-full flex items-center justify-center text-xs">3</div>
        </div>

        <div class="grid grid-cols-2 gap-8 text-sm">
            <div>
                <h3 class="font-bold uppercase border-b border-gray-300 pb-2 mb-2">Item Details</h3>
                <p id="t-name" class="font-medium"></p>
                <p id="t-qty" class="text-gray-500"></p>
                <p id="t-price" class="mt-2 font-bold"></p>
            </div>
            <div>
                <h3 class="font-bold uppercase border-b border-gray-300 pb-2 mb-2">Delivery Info</h3>
                <p>Standard Shipping</p>
                <p class="text-gray-500">Estimated Delivery: 3-5 Business Days</p>
            </div>
        </div>
    </div>
    
    <div id="error-msg" class="hidden text-center py-12 text-red-500">Order not found.</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch(`/api/orders/${orderId}`)
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                  const order = data.data;
                  document.getElementById('loading').classList.add('hidden');
                  document.getElementById('track-content').classList.remove('hidden');

                  document.getElementById('t-order-num').innerText = 'Order #' + order.id;
                  document.getElementById('t-status').innerText = order.status; // Delivery status
                  
                  document.getElementById('t-name').innerText = order.product_name;
                  document.getElementById('t-qty').innerText = 'Qty: ' + order.quantity;
                  document.getElementById('t-price').innerText = '$' + parseFloat(order.price).toFixed(2);
                } else {
                    document.getElementById('loading').classList.add('hidden');
                    document.getElementById('error-msg').classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('error-msg').classList.remove('hidden');
            });
    });
</script>
@endsection
