@extends('layouts.frontend')

@section('content')
<div class="px-4 py-12 mx-auto container">
    <h1 class="mb-8 text-3xl font-bold uppercase tracking-wider">The Exclusives</h1>

    <div id="loading" class="text-center py-12 text-gray-500">Loading exclusives...</div>

    <div id="ex-grid" class="grid-cols-2 gap-6 md:grid-cols-4 hidden">
        <!-- Injected -->
    </div>
    
    <div id="ex-empty" class="hidden py-12 text-center text-gray-500 col-span-4">
        <p>No products found.</p>
    </div>
</div>

<div class="py-12 border-t border-b border-gray-200">
    <div class="grid grid-cols-1 gap-8 px-4 mx-auto max-w-6xl md:grid-cols-3">
        <div>
            <h4 class="mb-4 text-sm font-bold uppercase tracking-wider">Client Care</h4>
            <p class="text-sm text-gray-600">CHANEL Client Care is available Monday to Sunday, 7 AM to 12 AM ET.</p>
            <p class="mt-2 text-sm text-gray-600">Please <a href="#" class="underline">email us</a> or call <a href="#" class="underline">1.800.550.0005</a></p>
        </div>
        <div>
            <h4 class="mb-4 text-sm font-bold uppercase tracking-wider">Find a Store</h4>
            <p class="mb-3 text-sm text-gray-600">Enter a location to find the closest CHANEL stores</p>
            <div class="flex border-b border-black">
                <input type="text" placeholder="City or zip code" class="flex-1 py-2 text-sm outline-none">
                <button class="font-bold">GO →</button>
            </div>
        </div>
        <div>
            <h4 class="mb-4 text-sm font-bold uppercase tracking-wider">Latest News</h4>
            <p class="mb-3 text-sm text-gray-600">Subscribe to receive news from CHANEL</p>
            <div class="flex border-b border-black">
                <input type="email" placeholder="Enter your email address" class="flex-1 py-2 text-sm outline-none">
                <button class="font-bold">OK →</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/products')
            .then(res => res.json())
            .then(data => {
                document.getElementById('loading').classList.add('hidden');
                
                if (data.success && data.data.length > 0) {
                    const grid = document.getElementById('ex-grid');
                    grid.classList.remove('hidden');
                    grid.classList.add('grid');
                    
                    data.data.forEach(product => {
                         const html = `
                            <div class="p-4 text-center transition-shadow border border-gray-200 shadow-sm hover:shadow-md">
                                <a href="/product/${product.id}" class="block">
                                    <div class="mb-3 overflow-hidden bg-gray-100">
                                        <img src="${product.image}" 
                                             alt="${product.name}" 
                                             class="object-contain w-full h-48 transition-transform duration-300 hover:scale-105">
                                    </div>
                                    <h3 class="text-sm font-semibold uppercase">${product.name}</h3>
                                    <p class="mt-1 text-xs text-gray-500">${product.description ? product.description.substring(0, 50) : ''}</p>
                                    <p class="mt-2 font-bold">$${parseFloat(product.price).toFixed(2)}</p>
                                </a>
                                <button onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price}, '${product.image}')" class="mt-3 block w-full px-6 py-2 text-sm font-semibold transition-colors border border-black hover:bg-black hover:text-white">Add to Bag</button>
                            </div>
                        `;
                        grid.insertAdjacentHTML('beforeend', html);
                    });
                } else {
                    document.getElementById('ex-empty').classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('loading').innerText = 'Error loading exclusives.';
            });
    });

    function addToCart(id, name, price, image) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push({ id, name, price, image, quantity: 1 });
        localStorage.setItem('cart', JSON.stringify(cart));
        alert('Added to bag!');
    }
</script>
@endsection
