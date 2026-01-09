@extends('layouts.frontend')

@section('content')
<div class="px-4 py-12 mx-auto container">
    <h1 class="mb-8 text-3xl font-bold uppercase tracking-wider">The Exclusives</h1>

    <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
        @forelse($products as $product)
        <div class="p-4 text-center transition-shadow border border-gray-200 shadow-sm hover:shadow-md">
            <a href="{{ route('product.show', $product->id) }}" class="block">
                <div class="mb-3 overflow-hidden bg-gray-100">
                    <img src="{{ asset($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="object-contain w-full h-48 transition-transform duration-300 hover:scale-105">
                </div>
                <h3 class="text-sm font-semibold uppercase">{{ $product->name }}</h3>
                <p class="mt-1 text-xs text-gray-500">{{ $product->description }}</p>
                <p class="mt-2 font-bold">${{ number_format($product->price, 2) }}</p>
            </a>
            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="px-6 py-2 text-sm font-semibold transition-colors border border-black hover:bg-black hover:text-white">Add to Bag</button>
            </form>
        </div>
        @empty
        <div class="py-12 text-center text-gray-500 col-span-4">
            <p>No products found.</p>
        </div>
        @endforelse
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
@endsection
