@extends('layouts.frontend')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold uppercase tracking-wider mb-8">EXCLUSIVES</h1>

    <!-- Products Grid from Database -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="border border-gray-200 p-4 text-center shadow-sm hover:shadow-md transition-shadow">
            <a href="{{ route('product.show', $product->id) }}" class="block">
                <div class="bg-gray-100 overflow-hidden mb-3">
                    <img src="{{ asset($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-48 object-contain hover:scale-105 transition-transform duration-300">
                </div>
                <h3 class="font-semibold text-sm uppercase">{{ $product->name }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $product->description }}</p>
                <p class="font-bold mt-2">${{ number_format($product->price, 2) }}</p>
            </a>
            <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="px-6 py-2 border border-black hover:bg-black hover:text-white transition-colors text-sm font-semibold">Add to Bag</button>
            </form>
        </div>
        @empty
        <div class="col-span-4 text-center py-12 text-gray-500">
            <p>No products found.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Support Section -->
<div class="border-t border-b border-gray-200 py-12">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Contact an Advisor</h4>
            <p class="text-sm text-gray-600">CHANEL Client Care is available Monday to Sunday, 7 AM to 12 AM ET.</p>
            <p class="text-sm text-gray-600 mt-2">Please <a href="#" class="underline">email us</a> or call <a href="#" class="underline">1.800.550.0005</a></p>
        </div>
        <div>
            <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Find a Store</h4>
            <p class="text-sm text-gray-600 mb-3">Enter a location to find the closest CHANEL stores</p>
            <div class="flex border-b border-black">
                <input type="text" placeholder="City or zip code" class="flex-1 py-2 outline-none text-sm">
                <button class="font-bold">GO →</button>
            </div>
        </div>
        <div>
            <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Newsletter</h4>
            <p class="text-sm text-gray-600 mb-3">Subscribe to receive news from CHANEL</p>
            <div class="flex border-b border-black">
                <input type="email" placeholder="Enter your email address" class="flex-1 py-2 outline-none text-sm">
                <button class="font-bold">OK →</button>
            </div>
        </div>
    </div>
</div>
@endsection
