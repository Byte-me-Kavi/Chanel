@extends('layouts.frontend')

@section('content')
<div class="max-w-5xl mx-auto my-12 px-4">
    <h1 class="text-3xl font-light tracking-widest text-center mb-8">My Wishlist</h1>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-center">
        {{ session('success') }}
    </div>
    @endif

    @if(session('info'))
    <div class="mb-4 p-3 bg-blue-100 text-blue-800 rounded text-center">
        {{ session('info') }}
    </div>
    @endif

    @if($wishlistItems->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($wishlistItems as $item)
        <div class="border border-gray-200 p-4 text-center shadow-sm hover:shadow-md transition-shadow relative">
            <a href="{{ route('product.show', $item->product->id) }}" class="block">
                <div class="bg-gray-100 overflow-hidden mb-3">
                    <img src="{{ asset($item->product->image) }}" 
                         alt="{{ $item->product->name }}" 
                         class="w-full h-48 object-contain hover:scale-105 transition-transform duration-300">
                </div>
                <h3 class="font-semibold text-sm uppercase">{{ $item->product->name }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($item->product->description, 50) }}</p>
                <p class="font-bold mt-2">${{ number_format($item->product->price, 2) }}</p>
            </a>
            
            <div class="flex gap-2 mt-3">
                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                    <button type="submit" class="w-full px-3 py-2 bg-black text-white text-xs hover:bg-gray-800 transition-colors">Add to Bag</button>
                </form>
                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 border border-gray-300 text-gray-500 hover:border-red-500 hover:text-red-500 transition-colors" title="Remove">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <div class="text-6xl mb-4">💖</div>
        <p class="text-gray-500 text-lg">Your wishlist is empty.</p>
        <a href="{{ route('product') }}" class="inline-block mt-4 bg-black text-white py-3 px-8 uppercase tracking-wider hover:bg-gray-800">Browse Products</a>
    </div>
    @endif
</div>
@endsection
