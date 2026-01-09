@extends('layouts.frontend')

@section('content')
<div class="px-4 py-12 mx-auto max-w-6xl">
    <h1 class="mb-8 text-3xl font-light text-center uppercase tracking-widest">Find Your Fragrance</h1>

    <form action="{{ route('search') }}" method="GET" class="mb-12 mx-auto max-w-xl">
        <div class="flex border-b-2 border-black">
            <input type="text" name="q" value="{{ $query }}" placeholder="Search products..." 
                   class="flex-1 px-2 py-3 text-lg outline-none" autofocus>
            <button type="submit" class="px-4 transition-opacity hover:opacity-60">
                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" /></svg>
            </button>
        </div>
    </form>

    @if(!empty($query))
        <p class="mb-8 text-center text-gray-600">
            {{ $products->count() }} result(s) for "<strong>{{ $query }}</strong>"
        </p>

        @if($products->count() > 0)
        <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
            @foreach($products as $product)
            <div class="p-4 text-center transition-shadow border border-gray-200 shadow-sm hover:shadow-md">
                <a href="{{ route('product.show', $product->id) }}" class="block">
                    <div class="mb-3 overflow-hidden bg-gray-100">
                        <img src="{{ asset($product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="object-contain w-full h-48 transition-transform duration-300 hover:scale-105">
                    </div>
                    <h3 class="text-sm font-semibold uppercase">{{ $product->name }}</h3>
                    <p class="mt-1 text-xs text-gray-500">{{ Str::limit($product->description, 50) }}</p>
                    <p class="mt-2 font-bold">${{ number_format($product->price, 2) }}</p>
                </a>
                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="px-6 py-2 text-sm font-semibold transition-colors border border-black hover:bg-black hover:text-white">Add to Bag</button>
                </form>
            </div>
            @endforeach
        </div>
        @else
        <div class="py-12 text-center">
            <p class="text-lg text-gray-500">We couldn't find a match.</p>
            <a href="{{ route('product') }}" class="inline-block px-8 py-3 mt-4 text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">Browse All Products</a>
        </div>
        @endif
    @else
        <div class="py-12 text-center">
            <p class="text-gray-500">Enter a search term to find products.</p>
        </div>
    @endif
</div>
@endsection
