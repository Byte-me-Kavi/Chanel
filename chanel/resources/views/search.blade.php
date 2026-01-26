@extends('layouts.frontend')

@section('content')
<div class="px-4 mx-auto my-12 max-w-7xl">
    <h1 class="mb-8 text-3xl font-light text-center uppercase tracking-widest">Search Results</h1>
    <p class="text-center text-gray-500 mb-8">Results for: <span class="font-bold">"{{ $query }}"</span></p>

    <div id="loading" class="text-center py-12 text-gray-500">Searching...</div>

    <div id="search-grid" class="grid-cols-2 gap-6 md:grid-cols-4 hidden">
        <!-- Results -->
    </div>

    <div id="no-results" class="hidden py-12 text-center text-gray-500">
        No products found matching your criteria.
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const query = "{{ $query }}";
        if(!query) {
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('no-results').classList.remove('hidden');
            return;
        }

        fetch(`/api/products?search=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('loading').classList.add('hidden');
                
                if (data.success && data.data.length > 0) {
                    const grid = document.getElementById('search-grid');
                    grid.classList.remove('hidden');
                    grid.classList.add('grid');
                    
                    data.data.forEach(product => {
                        const html = `
                            <div class="p-4 text-center border border-gray-200 shadow-sm transition-shadow hover:shadow-md">
                                <a href="/product/${product.id}" class="block">
                                    <div class="mb-3 overflow-hidden bg-gray-100">
                                        <img src="${product.image}" alt="${product.name}" class="object-contain w-full h-48 transition-transform duration-300 hover:scale-105">
                                    </div>
                                    <h3 class="text-sm font-semibold uppercase">${product.name}</h3>
                                    <p class="mt-1 text-xs text-gray-500">${product.description ? product.description.substring(0, 50) : ''}</p>
                                    <p class="mt-2 font-bold">$${parseFloat(product.price).toFixed(2)}</p>
                                </a>
                                <button onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price}, '${product.image}')" class="mt-3 block w-full px-6 py-2 text-sm font-semibold border border-black transition-colors hover:text-white hover:bg-black">Add to Bag</button>
                            </div>
                        `;
                        grid.insertAdjacentHTML('beforeend', html);
                    });
                } else {
                    document.getElementById('no-results').classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('loading').innerText = 'Error performing search.';
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
