@extends('layouts.frontend')

@section('content')
<div class="px-4 mx-auto my-12 max-w-5xl">
    <h1 class="mb-8 text-3xl font-light text-center uppercase tracking-widest">Your Wishlist</h1>

    @if(session('success'))
    <div class="p-3 mb-4 text-center text-green-800 bg-green-100 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('info'))
    <div class="p-3 mb-4 text-center text-blue-800 bg-blue-100 rounded">
        {{ session('info') }}
    </div>
    @endif

    @if($wishlistItems->count() > 0)
    <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
        @foreach($wishlistItems as $item)
        <div class="relative p-4 text-center transition-shadow border border-gray-200 shadow-sm hover:shadow-md">
            <a href="{{ route('product.show', $item->product->id) }}" class="block">
                <div class="mb-3 overflow-hidden bg-gray-100">
                    <img src="{{ asset($item->product->image) }}" 
                         alt="{{ $item->product->name }}" 
                         class="object-contain w-full h-48 transition-transform duration-300 hover:scale-105">
                </div>
                <h3 class="text-sm font-semibold uppercase">{{ $item->product->name }}</h3>
                <p class="mt-1 text-xs text-gray-500">{{ Str::limit($item->product->description, 50) }}</p>
                <p class="mt-2 font-bold">${{ number_format($item->product->price, 2) }}</p>
            </a>
            
            <div class="flex gap-2 mt-3">
                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                    <button type="submit" class="px-3 py-2 w-full text-xs text-white transition-colors bg-black hover:bg-gray-800">ADD TO BAG</button>
                </form>
                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 text-gray-500 transition-colors border border-gray-300 hover:border-red-500 hover:text-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="py-12 text-center">
        <p class="text-lg text-gray-500">Your wishlist is empty.</p>
        <a href="{{ route('product') }}" class="inline-block px-8 py-3 mt-4 text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">Browse Products</a>
    </div>
    @endif
</div>
@endsection
