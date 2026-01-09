@extends('layouts.frontend')

@section('content')

<section class="justify-center flex bg-center bg-cover items-center text-center relative h-[50vh] text-white" style="background-image: url('{{ asset('img/img3.webp') }}');">
    <div class="p-8 bg-black/30">
        <h1 class="font-bold text-3xl md:text-4xl uppercase tracking-wider">BLEU DE CHANEL L'EXCLUSIF</h1>
        <a href="#" class="inline-block px-8 py-3 mt-4 border border-white uppercase tracking-widest hover:text-black hover:bg-white transition-colors">Discover The New Fragrance</a>
    </div>
</section>

<div class="px-4 py-12 mx-auto container">
    <h2 class="mb-8 font-semibold text-center text-xl uppercase tracking-[0.2em]">Our Products</h2>

    <div class="gap-6 grid grid-cols-2 md:grid-cols-4">
        @forelse($products as $product)
        <div class="p-4 text-center border border-gray-200 shadow-sm transition-shadow hover:shadow-md">
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
                <button type="submit" class="px-6 py-2 text-sm font-semibold border border-black transition-colors hover:text-white hover:bg-black">Add to Bag</button>
            </form>
        </div>
        @empty
        <div class="col-span-4 py-12 text-center text-gray-500">
            <p>No products found.</p>
        </div>
        @endforelse
    </div>
</div>

<div class="py-12 border-t border-b border-gray-200">
    <div class="grid max-w-6xl grid-cols-1 gap-8 mx-auto px-4 md:grid-cols-3">
        <div>
            <h4 class="mb-4 text-sm font-bold uppercase tracking-wider">Need Help?</h4>
            <p class="text-sm text-gray-600">CHANEL Client Care is available to assist you.</p>
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
            <h4 class="mb-4 text-sm font-bold uppercase tracking-wider">Stay Updated</h4>
            <p class="mb-3 text-sm text-gray-600">Subscribe/Newsletter</p>
            <div class="flex border-b border-black">
                <input type="email" placeholder="Enter your email address" class="flex-1 py-2 text-sm outline-none">
                <button class="font-bold">OK →</button>
            </div>
        </div>
    </div>
</div>
@endsection
