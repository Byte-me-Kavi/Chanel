@extends('layouts.frontend')

@section('content')
<main class="mx-auto mt-10 max-w-7xl px-4">
    <div class="grid grid-cols-1 gap-x-16 lg:grid-cols-2">
        
        <!-- Product Images -->
        <div class="space-y-8">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full">
        </div>
        
        <!-- Product Details -->
        <div class="mt-10 lg:mt-0" style="position: sticky; top: 2.5rem; align-self: flex-start;">
            <div id="product-details-container">
                <h1 class="border-b border-black pb-2 text-3xl font-light uppercase tracking-wider">{{ $product->name }}</h1>
                <p class="mt-4 text-sm text-gray-500">{{ $product->description }}</p>
                <p class="mt-4 text-sm text-gray-400">Ref. {{ $product->id }}</p>
                <div class="mt-6 flex items-center justify-between">
                    <p class="text-2xl font-medium">${{ number_format($product->price, 2) }}</p>
                </div>
                <div class="mt-8">
                    <label for="size-select" class="text-xs font-bold tracking-wider">SIZE OPTIONS</label>
                    <select id="size-select" class="mt-2 w-full appearance-none border border-gray-400 p-3 text-sm focus:border-black focus:outline-none focus:ring-2 focus:ring-black">
                        <option>1.7 FL. OZ.</option>
                        <option>3.4 FL. OZ.</option>
                        <option>5.0 FL. OZ.</option>
                    </select>
                </div>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="mt-8 w-full bg-black py-4 text-sm uppercase tracking-widest text-white transition-colors hover:bg-gray-800">Add to Bag</button>
                </form>
                @auth
                <form action="{{ route('wishlist.add') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="w-full border border-black py-3 text-sm uppercase tracking-widest text-black transition-colors hover:bg-black hover:text-white flex items-center justify-center gap-2">
                        <svg viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>
                        Add to Wishlist
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="mt-3 w-full border border-black py-3 text-sm uppercase tracking-widest text-black transition-colors hover:bg-black hover:text-white flex items-center justify-center gap-2">
                    <svg viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>
                    Add to Wishlist
                </a>
                @endauth
            </div>
            
            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="mt-16 border-t border-gray-200 pt-10 text-center">
                <h2 class="relative mb-10 inline-block text-lg font-normal uppercase tracking-widest">The Perfect Match</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($relatedProducts->take(2) as $related)
                    <div class="text-center">
                        <a href="{{ route('product.show', $related->id) }}">
                            <img src="{{ asset($related->image) }}" alt="{{ $related->name }}" class="mx-auto mb-4 h-auto w-4/5 max-w-[200px] hover:scale-105 transition-transform">
                        </a>
                        <p class="my-2 text-sm font-bold uppercase">{{ $related->name }}</p>
                        <p class="text-sm text-gray-500">{{ Str::limit($related->description, 30) }}</p>
                        <p class="mt-2 font-medium">${{ number_format($related->price, 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Product Information Accordion -->
    <section id="reviews-section" class="my-20" x-data="{ open: null }">
        <h2 class="text-center text-xl font-medium uppercase tracking-[0.2em] mb-8">PRODUCT INFORMATION</h2>
        <div class="mx-auto max-w-4xl border-b border-t border-black">
            <!-- Description -->
            <div class="border-b border-gray-200">
                <button @click="open = open === 'desc' ? null : 'desc'" class="flex w-full cursor-pointer items-center justify-between border-none bg-transparent py-5 text-left text-sm">
                    <span class="font-semibold uppercase tracking-wider">DESCRIPTION</span>
                    <svg :class="open === 'desc' ? 'rotate-180' : ''" class="h-5 w-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open === 'desc'" x-transition class="pb-5 text-sm leading-relaxed text-gray-700">
                    <p class="mb-4"><strong class="mb-1 block font-bold text-black">Product</strong><br>{{ $product->description }}</p>
                </div>
            </div>
            
            <!-- Reviews Section -->
            <div class="border-b border-gray-200">
                <button @click="open = open === 'reviews' ? null : 'reviews'" class="flex w-full cursor-pointer items-center justify-between border-none bg-transparent py-5 text-left text-sm">
                    <span class="font-semibold uppercase tracking-wider">REVIEWS ({{ $product->reviews->count() }})</span>
                    <svg :class="open === 'reviews' ? 'rotate-180' : ''" class="h-5 w-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open === 'reviews'" x-transition class="p-5">
                    @if($product->reviews->count() === 0)
                        <p class="text-gray-500">Be the first to review this product.</p>
                    @else
                        @foreach($product->reviews as $review)
                        <div class="mb-6 border-b border-gray-200 pb-6 last:mb-0 last:border-b-0 last:pb-0">
                            <div class="flex items-center justify-between">
                                <h4 class="font-bold">{{ $review->author_name }}</h4>
                                <span class="text-xs text-gray-500">{{ $review->created_at->format('m/d/Y') }}</span>
                            </div>
                            <div class="mt-1 flex">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="h-4 w-4 {{ $i < $review->rating ? 'text-amber-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <p class="mt-3 leading-relaxed text-gray-700">{{ $review->review_text }}</p>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Write a Review Form -->
    <div class="mx-auto mt-20 max-w-2xl rounded-lg border border-gray-200 bg-gray-50 p-8 mb-20">
        <h2 class="mt-0 text-center text-xl font-medium uppercase tracking-[0.2em]">WRITE A REVIEW</h2>
        
        @if(session('review_success'))
        <div class="mb-4 rounded-md p-3 text-center bg-green-100 text-green-800">
            {{ session('review_success') }}
        </div>
        @endif
        
        @if($errors->any())
        <div class="mb-4 rounded-md p-3 text-center bg-red-100 text-red-800">
            Please fill all required fields.
        </div>
        @endif
        
        <form method="POST" action="{{ route('review.store', $product->id) }}">
            @csrf
            <div class="mb-5">
                <label for="author_name" class="mb-2 block text-sm font-medium">Your Name</label>
                <input type="text" name="author_name" id="author_name" required class="block w-full rounded-md border border-gray-300 bg-white p-3 transition-shadow focus:border-black focus:outline-none focus:ring-2 focus:ring-black">
            </div>
            <div class="mb-5">
                <label class="mb-2 block text-sm font-medium">Rating</label>
                <div class="star-rating flex flex-row-reverse justify-end">
                    @for($i = 5; $i >= 1; $i--)
                    <input type="radio" id="{{ $i }}-stars" name="rating" value="{{ $i }}" class="hidden peer" {{ $i == 5 ? 'required' : '' }}>
                    <label for="{{ $i }}-stars" class="cursor-pointer text-2xl text-gray-300 hover:text-amber-500 peer-checked:text-amber-500">&#9733;</label>
                    @endfor
                </div>
            </div>
            <div class="mb-5">
                <label for="review_text" class="mb-2 block text-sm font-medium">Review</label>
                <textarea name="review_text" id="review_text" rows="4" required class="block w-full rounded-md border border-gray-300 bg-white p-3 transition-shadow focus:border-black focus:outline-none focus:ring-2 focus:ring-black"></textarea>
            </div>
            <div>
                <button type="submit" class="w-full cursor-pointer rounded border-none bg-black py-3.5 text-sm uppercase tracking-widest text-white transition-colors hover:bg-gray-800">Submit Review</button>
            </div>
        </form>
    </div>
</main>

<style>
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #f59e0b;
    }
</style>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
