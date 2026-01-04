@extends('layouts.frontend')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-light tracking-widest text-center mb-8">SEARCH</h1>

    <!-- Search Form -->
    <form action="{{ route('search') }}" method="GET" class="max-w-xl mx-auto mb-12">
        <div class="flex border-b-2 border-black">
            <input type="text" name="q" value="{{ $query }}" placeholder="Search products..." 
                   class="flex-1 py-3 px-2 text-lg outline-none" autofocus>
            <button type="submit" class="px-4 hover:opacity-60 transition-opacity">
                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" /></svg>
            </button>
        </div>
    </form>

    @if(!empty($query))
        <p class="text-center text-gray-600 mb-8">
            {{ $products->count() }} result(s) for "<strong>{{ $query }}</strong>"
        </p>

        @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="border border-gray-200 p-4 text-center shadow-sm hover:shadow-md transition-shadow">
                <a href="{{ route('product.show', $product->id) }}" class="block">
                    <div class="bg-gray-100 overflow-hidden mb-3">
                        <img src="{{ asset($product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-contain hover:scale-105 transition-transform duration-300">
                    </div>
                    <h3 class="font-semibold text-sm uppercase">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($product->description, 50) }}</p>
                    <p class="font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                </a>
                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="px-6 py-2 border border-black hover:bg-black hover:text-white transition-colors text-sm font-semibold">Add to Bag</button>
                </form>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">No products found matching your search.</p>
            <a href="{{ route('product') }}" class="inline-block mt-4 bg-black text-white py-3 px-8 uppercase tracking-wider hover:bg-gray-800">Browse All Products</a>
        </div>
        @endif
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">Enter a search term to find products.</p>
        </div>
    @endif
</div>
@endsection
