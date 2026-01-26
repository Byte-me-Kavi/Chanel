@extends('layouts.frontend')

@section('content')
<main class="mx-auto mt-10 max-w-7xl px-4">
    <!-- ID passed from controller -->
    <script>
        const productId = {{ $id }};
        const isAuth = @json(Auth::check());
    </script>

    <div id="loading" class="text-center py-20 text-gray-500">Loading product details...</div>

    <div id="product-content" class="grid-cols-1 gap-x-16 lg:grid-cols-2 hidden">
        
        <!-- Product Images -->
        <div class="space-y-8">
            <img id="p-image" src="" alt="" class="w-full">
        </div>
        
        <!-- Product Details -->
        <div class="mt-10 lg:mt-0" style="position: sticky; top: 2.5rem; align-self: flex-start;">
            <div id="product-details-container">
                <h1 id="p-name" class="border-b border-black pb-2 text-3xl font-light uppercase tracking-wider"></h1>
                <p id="p-desc" class="mt-4 text-sm text-gray-500"></p>
                <p id="p-ref" class="mt-4 text-sm text-gray-400"></p>
                <div class="mt-6 flex items-center justify-between">
                    <p id="p-price" class="text-2xl font-medium"></p>
                </div>
                
                <div class="mt-8">
                    <label for="size-select" class="text-xs font-bold tracking-wider">SIZE OPTIONS</label>
                    <select id="size-select" class="mt-2 w-full appearance-none border border-gray-400 p-3 text-sm focus:border-black focus:outline-none focus:ring-2 focus:ring-black">
                        <option>1.7 FL. OZ.</option>
                        <option>3.4 FL. OZ.</option>
                        <option>5.0 FL. OZ.</option>
                    </select>
                </div>

                <!-- Add to Cart -->
                <button id="add-to-bag-btn" class="mt-8 w-full bg-black py-4 text-sm uppercase tracking-widest text-white transition-colors hover:bg-gray-800">Add to Bag</button>

                <!-- Wishlist -->
                <div id="wishlist-container">
                    <!-- Injected via JS based on Auth -->
                </div>
            </div>
            
            <!-- Related Products -->
            <div id="related-section" class="mt-16 border-t border-gray-200 pt-10 text-center hidden">
                <h2 class="relative mb-10 inline-block text-lg font-normal uppercase tracking-widest">The Perfect Match</h2>
                <div id="related-grid" class="grid grid-cols-2 gap-4">
                    <!-- Related items -->
                </div>
            </div>
        </div>
    </div>

    <!-- Product Information Accordion -->
    <section id="reviews-section" class="my-20 hidden" x-data="{ open: null }">
        <h2 class="text-center text-xl font-medium uppercase tracking-[0.2em] mb-8">PRODUCT INFORMATION</h2>
        <div class="mx-auto max-w-4xl border-b border-t border-black">
            <!-- Description -->
            <div class="border-b border-gray-200">
                <button @click="open = open === 'desc' ? null : 'desc'" class="flex w-full cursor-pointer items-center justify-between border-none bg-transparent py-5 text-left text-sm">
                    <span class="font-semibold uppercase tracking-wider">DESCRIPTION</span>
                    <svg :class="open === 'desc' ? 'rotate-180' : ''" class="h-5 w-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open === 'desc'" x-transition class="pb-5 text-sm leading-relaxed text-gray-700">
                    <p class="mb-4"><strong class="mb-1 block font-bold text-black">Product</strong><br><span id="desc-text"></span></p>
                </div>
            </div>
            
            <!-- Reviews Section -->
             <div class="border-b border-gray-200">
                <button @click="open = open === 'reviews' ? null : 'reviews'" class="flex w-full cursor-pointer items-center justify-between border-none bg-transparent py-5 text-left text-sm">
                    <span class="font-semibold uppercase tracking-wider">REVIEWS <span id="review-count"></span></span>
                    <svg :class="open === 'reviews' ? 'rotate-180' : ''" class="h-5 w-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open === 'reviews'" x-transition class="p-5" id="reviews-container">
                    <p class="text-gray-500">Reviews are loading via API...</p> 
                </div>
            </div>
        </div>
    </section>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch(`/api/products/${productId}`)
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const p = data.data;
                    const related = data.related;

                    // Populate Data
                    document.getElementById('p-image').src = p.image;
                    document.getElementById('p-image').alt = p.name;
                    document.getElementById('p-name').innerText = p.name;
                    document.getElementById('p-desc').innerText = p.description;
                    document.getElementById('desc-text').innerText = p.description;
                    document.getElementById('p-ref').innerText = 'Ref. ' + p.id;
                    document.getElementById('p-price').innerText = '$' + parseFloat(p.price).toFixed(2);
                    
                    // Cart Logic
                    document.getElementById('add-to-bag-btn').onclick = function() {
                        let cart = JSON.parse(localStorage.getItem('cart')) || [];
                        cart.push({ 
                            id: p.id, 
                            name: p.name, 
                            price: p.price, 
                            image: p.image, 
                            quantity: 1 
                        });
                        localStorage.setItem('cart', JSON.stringify(cart));
                        alert('Added to bag!');
                    };

                    // Wishlist Auth Logic
                    const wishlistContainer = document.getElementById('wishlist-container');
                    if (isAuth) {
                        wishlistContainer.innerHTML = `
                        <form action="/wishlist/add" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="${p.id}">
                            <button type="submit" class="w-full border border-black py-3 text-sm uppercase tracking-widest text-black transition-colors hover:bg-black hover:text-white flex items-center justify-center gap-2">
                                <svg viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>
                                Add to Wishlist
                            </button>
                        </form>`;
                    } else {
                        wishlistContainer.innerHTML = `
                        <a href="/login" class="mt-3 w-full border border-black py-3 text-sm uppercase tracking-widest text-black transition-colors hover:bg-black hover:text-white flex items-center justify-center gap-2">
                             <svg viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>
                             Add to Wishlist
                        </a>`;
                    }

                    // Related
                    if(related && related.length > 0) {
                        const relatedGrid = document.getElementById('related-grid');
                        related.slice(0, 2).forEach(rel => {
                             relatedGrid.innerHTML += `
                                <div class="text-center">
                                    <a href="/product/${rel.id}">
                                        <img src="${rel.image}" alt="${rel.name}" class="mx-auto mb-4 h-auto w-4/5 max-w-[200px] hover:scale-105 transition-transform">
                                    </a>
                                    <p class="my-2 text-sm font-bold uppercase">${rel.name}</p>
                                    <p class="text-sm text-gray-500">${rel.description ? rel.description.substring(0, 30) + '...' : ''}</p>
                                    <p class="mt-2 font-medium">$${parseFloat(rel.price).toFixed(2)}</p>
                                </div>
                             `;
                        });
                        document.getElementById('related-section').classList.remove('hidden');
                    }
                    
                    // Reviews
                    const reviewsContainer = document.getElementById('reviews-container');
                    const reviewCount = document.getElementById('review-count');
                    
                    if (p.reviews && p.reviews.length > 0) {
                         reviewCount.innerText = `(${p.reviews.length})`;
                         reviewsContainer.innerHTML = ''; // Clear loading/placeholder
                         p.reviews.forEach(r => {
                            let stars = '';
                            for(let i=0; i<5; i++) {
                                stars += `<svg class="h-4 w-4 ${i < r.rating ? 'text-amber-500' : 'text-gray-300'}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>`;
                            }
                            
                            const rHtml = `
                            <div class="mb-6 border-b border-gray-200 pb-6 last:mb-0 last:border-b-0 last:pb-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold">${r.author_name}</h4>
                                </div>
                                <div class="mt-1 flex">
                                    ${stars}
                                </div>
                                <p class="mt-3 leading-relaxed text-gray-700">${r.review_text}</p>
                            </div>
                            `;
                            reviewsContainer.insertAdjacentHTML('beforeend', rHtml);
                         });
                    } else {
                        reviewCount.innerText = '(0)';
                        reviewsContainer.innerHTML = '<p class="text-gray-500">Be the first to review this product.</p>';
                    }

                    // Show content
                    document.getElementById('loading').classList.add('hidden');
                    const content = document.getElementById('product-content');
                    content.classList.remove('hidden');
                    content.classList.add('grid');
                    document.getElementById('reviews-section').classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                document.getElementById('loading').innerText = 'Error loading product.';
            });
    });
</script>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
