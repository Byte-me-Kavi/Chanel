@extends('layouts.frontend')

@section('content')
<div class="px-4 mx-auto my-12 max-w-5xl">
    <h1 class="mb-8 text-3xl font-light text-center uppercase tracking-widest">Order History</h1>

    <div id="loading" class="text-center py-12 text-gray-500">Loading orders...</div>

    <div id="orders-container" class="space-y-6 hidden">
        <!-- Injected via JS -->
    </div>

    <div id="orders-empty" class="hidden py-12 text-center">
        <p class="text-lg text-gray-500">You haven't placed any orders yet.</p>
        <a href="{{ route('product') }}" class="inline-block px-8 py-3 mt-4 text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">Start Shopping</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/orders')
            .then(res => res.json())
            .then(data => {
                const loading = document.getElementById('loading');
                const container = document.getElementById('orders-container');
                const empty = document.getElementById('orders-empty');

                loading.classList.add('hidden');

                if (data.success && data.data.length > 0) {
                    container.classList.remove('hidden');
                    data.data.forEach(order => {
                        const date = new Date(order.created_at).toLocaleDateString();
                        const html = `
                        <div class="p-6 border border-gray-200 bg-gray-50">
                            <div class="flex flex-wrap items-center justify-between gap-4 mb-4 border-b border-gray-200 pb-4">
                                <div>
                                    <h3 class="font-bold uppercase tracking-wider">Order #${order.id}</h3>
                                    <p class="text-xs text-gray-500">Placed on ${date}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 text-xs font-bold uppercase bg-white border border-black">${order.order_status}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <img src="${order.image || '/img/placeholder.jpg'}" alt="${order.product_name}" class="w-20 h-20 object-contain bg-white border border-gray-200">
                                <div class="flex-1">
                                    <h4 class="font-bold uppercase">${order.product_name}</h4>
                                    <p class="text-sm text-gray-600">Qty: ${order.quantity}</p>
                                    <p class="mt-1 font-medium">$${parseFloat(order.price).toFixed(2)}</p>
                                </div>
                                <div class="text-right flex flex-col gap-2">
                                     <a href="/orders/${order.id}/track" class="text-xs underline hover:no-underline">Track Order</a>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center text-sm">
                                <span class="text-gray-500">Status: ${order.status}</span>
                                <span class="font-bold">Total: $${(order.price * order.quantity).toFixed(2)}</span>
                            </div>
                        </div>
                        `;
                        container.insertAdjacentHTML('beforeend', html);
                    });
                } else {
                    empty.classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('loading').innerText = 'Error loading orders.';
            });
    });
</script>
@endsection
