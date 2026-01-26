@extends('layouts.frontend')

@section('content')
<div class="px-4 mx-auto my-12 max-w-5xl">
    <h1 class="mb-8 text-3xl font-light text-center uppercase tracking-widest">Your Wishlist</h1>

    <div id="loading" class="text-center py-12 text-gray-500">Loading wishlist...</div>
    
    <!-- Container for dynamic content -->
    <div id="wishlist-container" class="hidden">
        <div id="wishlist-grid" class="grid grid-cols-2 gap-6 md:grid-cols-4">
            <!-- Items injected here -->
        </div>
        
        <div id="wishlist-empty" class="hidden py-12 text-center">
            <p class="text-lg text-gray-500">Your wishlist is empty.</p>
            <a href="{{ route('product') }}" class="inline-block px-8 py-3 mt-4 text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">Browse Products</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/wishlist')
            .then(res => res.json())
            .then(data => {
                const loading = document.getElementById('loading');
                const container = document.getElementById('wishlist-container');
                const grid = document.getElementById('wishlist-grid');
                const empty = document.getElementById('wishlist-empty');

                loading.classList.add('hidden');
                container.classList.remove('hidden');

                if (data.success && data.data.length > 0) {
                    data.data.forEach(item => {
                        const product = item.product;
                        const html = `
                        <div class="relative p-4 text-center transition-shadow border border-gray-200 shadow-sm hover:shadow-md" id="wish-item-${item.id}">
                            <a href="/product/${product.id}" class="block">
                                <div class="mb-3 overflow-hidden bg-gray-100">
                                    <img src="${product.image}" 
                                         alt="${product.name}" 
                                         class="object-contain w-full h-48 transition-transform duration-300 hover:scale-105">
                                </div>
                                <h3 class="text-sm font-semibold uppercase">${product.name}</h3>
                                <p class="mt-1 text-xs text-gray-500">${product.description ? product.description.substring(0, 50) + '...' : ''}</p>
                                <p class="mt-2 font-bold">$${parseFloat(product.price).toFixed(2)}</p>
                            </a>
                            
                            <div class="flex gap-2 mt-3">
                                <button onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price}, '${product.image}')" class="px-3 py-2 w-full text-xs text-white transition-colors bg-black hover:bg-gray-800">ADD TO BAG</button>
                                <button onclick="removeFromWishlist(${item.id})" class="px-3 py-2 text-gray-500 transition-colors border border-gray-300 hover:border-red-500 hover:text-red-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                        `;
                        grid.insertAdjacentHTML('beforeend', html);
                    });
                } else {
                    empty.classList.remove('hidden');
                    grid.classList.add('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('loading').innerText = 'Error loading wishlist.';
            });
    });

    function addToCart(id, name, price, image) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push({ id, name, price, image, quantity: 1 });
        localStorage.setItem('cart', JSON.stringify(cart));
        alert('Added to bag!');
    }

    function removeFromWishlist(id) {
        if(!confirm('Remove from wishlist?')) return;

        fetch(`/api/wishlist/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // Remove element
                const el = document.getElementById(`wish-item-${id}`);
                if(el) el.remove();
                
                // Check if empty
                const grid = document.getElementById('wishlist-grid');
                if(grid.children.length === 0) {
                    grid.classList.add('hidden');
                    document.getElementById('wishlist-empty').classList.remove('hidden');
                }
            } else {
                alert('Could not remove item.');
            }
        });
    }
</script>
@endsection
