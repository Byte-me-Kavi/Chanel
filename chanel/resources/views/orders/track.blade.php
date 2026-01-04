@extends('layouts.frontend')

@section('content')
<div class="bg-gray-100 min-h-[60vh] flex items-center justify-center py-12">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
        <h2 class="text-2xl font-bold mb-6">Order Tracking</h2>
        <p class="mb-4">Order ID: <span class="font-semibold">#{{ $order->id }}</span></p>
        <p class="mb-2 text-sm text-gray-600">Product: <span class="font-medium">{{ $order->product_name }}</span></p>
        
        <div id="statusBox" class="p-6 border rounded-lg bg-gray-50 text-center text-lg font-semibold mt-6">
            <div class="text-3xl mb-3">
                @if($order->order_status === 'Delivered')
                    ✅
                @elseif($order->order_status === 'Shipped')
                    🚚
                @else
                    📦
                @endif
            </div>
            <div id="statusText">{{ $order->order_status }}</div>
            <div id="updatedAt" class="text-sm text-gray-500 mt-2">
                Updated: {{ $order->created_at ? $order->created_at->format('m/d/Y H:i') : 'N/A' }}
            </div>
        </div>

        <p class="text-xs text-gray-400 mt-4">Status updates automatically every 5 seconds</p>

        <a href="{{ route('orders.index') }}" class="inline-block mt-6 bg-black text-white py-3 px-8 uppercase text-xs tracking-widest hover:bg-gray-800">
            Back to My Orders
        </a>
    </div>
</div>

<script>
    const orderId = {{ $order->id }};

    async function fetchStatus() {
        try {
            const response = await fetch("{{ route('orders.status', $order->id) }}");
            if (response.ok) {
                const data = await response.json();
                document.getElementById("statusText").innerText = data.status;
                document.getElementById("updatedAt").innerText = "Updated: " + data.updated_at;
            }
        } catch (error) {
            console.error("Error fetching status:", error);
        }
    }

    // Fetch immediately and then every 5 seconds
    fetchStatus();
    setInterval(fetchStatus, 5000);
</script>
@endsection
