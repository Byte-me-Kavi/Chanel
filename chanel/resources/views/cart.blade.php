@extends('layouts.frontend')

@section('content')
<div class="max-w-5xl mx-auto my-12 px-4">
    <h1 class="text-4xl font-light tracking-widest text-center">My Shopping Bag</h1>
    <h2 class="text-center text-sm font-normal text-gray-600 mt-2">CHANEL presents each purchase in signature packaging</h2>

    @if(session('success'))
    <div class="mt-4 p-3 bg-green-100 text-green-800 rounded text-center">
        {{ session('success') }}
    </div>
    @endif

    <div class="mt-10">
        @if(count($cart) > 0)
            @foreach($cart as $index => $item)
            <div class="flex justify-between items-center border-b border-gray-200 py-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded">
                    <div>
                        <span class="text-lg font-medium">{{ $item['name'] }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-8">
                    <span class="text-base font-medium">${{ number_format($item['price'], 2) }}</span>
                    <form action="{{ route('cart.remove', $index) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-700 text-sm uppercase tracking-wider font-medium hover:underline">Remove</button>
                    </form>
                </div>
            </div>
            @endforeach

            <div class="mt-8 text-xl font-bold text-right">Total: ${{ number_format($total, 2) }}</div>

            <!-- WRAPPING OPTIONS -->
            <div class="mt-16">
                <h2 class="uppercase font-bold tracking-wider text-lg">WRAPPING OPTIONS</h2>
                <hr class="mt-2 mb-6 border-0 border-t border-black">
                <div class="space-y-4">
                    <div class="option-box border border-black p-5 cursor-pointer">
                        <label class="flex items-start">
                            <input type="radio" name="wrap" checked class="mt-5 mr-5 h-5 w-5 accent-black">
                            <div class="grow flex justify-between items-start">
                                <div class="flex items-start">
                                    <img src="{{ asset('img/es.webp') }}" alt="The Essential" class="w-20 mr-5">
                                    <div>
                                        <div class="font-bold uppercase">THE ESSENTIAL</div>
                                        <div class="max-w-lg text-gray-700 mt-1">An organic cotton pouch placed directly in a shipping box. This option is not available for Click & Collect.</div>
                                        <a href="#" class="text-gray-600 underline text-sm mt-2 inline-block">Learn more</a>
                                    </div>
                                </div>
                                <div class="font-bold">COMPLIMENTARY</div>
                            </div>
                        </label>
                    </div>
                    <div class="option-box border border-gray-300 p-5 cursor-pointer">
                        <label class="flex items-start">
                            <input type="radio" name="wrap" class="mt-5 mr-5 h-5 w-5 accent-black">
                            <div class="grow flex justify-between items-start">
                                <div class="flex items-start">
                                    <img src="{{ asset('img/cl.webp') }}" alt="The Classic" class="w-20 mr-5">
                                    <div>
                                        <div class="font-bold uppercase">THE CLASSIC</div>
                                        <div class="max-w-lg text-gray-700 mt-1">Presented in a signature black-and-white box or bag.</div>
                                        <a href="#" class="text-gray-600 underline text-sm mt-2 inline-block">Learn more</a>
                                    </div>
                                </div>
                                <div class="font-bold">COMPLIMENTARY</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- GIFT MESSAGE -->
            <div class="max-w-4xl mx-auto mt-16 p-8 bg-gray-50">
                <h3 class="font-bold uppercase tracking-wider">GIFT MESSAGE</h3>
                <hr class="border-0 border-t border-black mt-2 mb-5">
                <p class="text-gray-700 mb-6 max-w-3xl">Add a personal touch with a complimentary gift message. Choose to receive a blank card with your purchase, or write your message here and receive it printed.</p>
                <form class="space-y-3">
                    <label class="flex items-center cursor-pointer"><input type="radio" name="gift" checked class="h-4 w-4 mr-3 accent-black">Do not include a card</label>
                    <label class="flex items-center cursor-pointer"><input type="radio" name="gift" class="h-4 w-4 mr-3 accent-black">Include a blank card</label>
                    <label class="flex items-center cursor-pointer"><input type="radio" name="gift" class="h-4 w-4 mr-3 accent-black">Write a message</label>
                </form>
            </div>

            <!-- CHECKOUT BUTTON -->
            <div class="text-center mt-8">
                <a href="{{ route('checkout.index') }}" class="inline-block bg-black text-white py-3 px-8 uppercase tracking-wider text-base hover:bg-gray-800 rounded-sm">Checkout</a>
            </div>

        @else
            <div class="text-center py-12">
                <div class="text-lg text-gray-500">Your bag is empty.</div>
            </div>
        @endif
    </div>

    <div class="text-center my-8">
        <a href="{{ route('product') }}" class="inline-block px-8 py-4 text-center bg-linear-to-r from-black to-gray-700 border-none rounded-md text-white font-bold uppercase tracking-wider text-base hover:scale-105 transition-transform">Continue Shopping</a>
    </div>
</div>

<!-- PAYMENT SECTION -->
<div class="bg-gray-100 text-center py-10 px-5 mt-10">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-xl font-bold mb-5 tracking-wider">PAYMENT METHODS</h2>
        <div class="flex justify-center flex-wrap gap-4 items-center mb-8">
            <img src="{{ asset('img/visa.png') }}" alt="Visa" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
            <img src="{{ asset('img/am.png') }}" alt="American Express" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
            <img src="{{ asset('img/mas.png') }}" alt="MasterCard" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
            <img src="{{ asset('img/dis.png') }}" alt="Discover" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
        </div>
        <div>
            <h3 class="text-base font-bold mb-2">SECURE PAYMENT</h3>
            <p class="text-sm text-gray-700">Your credit card details are safe with us.</p>
            <p class="text-sm text-gray-700 my-1">All the information is protected using Secure Sockets Layer (SSL) technology.</p>
            <a href="#" class="inline-block mt-3 underline text-black text-sm">Privacy Policy</a>
        </div>
    </div>
</div>
@endsection
