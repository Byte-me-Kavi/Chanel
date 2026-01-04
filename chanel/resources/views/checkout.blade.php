@extends('layouts.frontend')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl lg:text-4xl text-center font-light tracking-[0.2em] my-12 uppercase">Checkout</h1>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded text-center">
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-16">
            <div class="lg:col-span-2">
                <p class="text-sm mb-6">Continue as a guest or log in to your personal account.</p>
                
                @auth
                <p class="text-sm text-gray-700 mb-6">Logged in as <strong>{{ Auth::user()->name }}</strong></p>
                @else
                <a href="{{ route('login') }}" class="inline-block bg-black text-white py-3 px-12 uppercase text-xs tracking-widest hover:bg-gray-800 transition-colors mb-6">Login to Continue</a>
                @endauth

                <div class="mt-12">
                    <h2 class="text-sm font-semibold tracking-widest">DELIVERY METHOD</h2>
                    <hr class="border-black mt-3 mb-6">
                    
                    <select name="delivery_method" required class="w-full p-3 border border-gray-300 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                        @foreach($deliveryMethods as $method)
                        <option value="{{ $method }}">{{ $method }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-12">
                    <h2 class="text-sm font-semibold tracking-widest">PAYMENT METHOD</h2>
                    <hr class="border-black mt-3 mb-6">
                    <p class="text-sm text-gray-500">Payment integration would appear here.</p>
                </div>
                
                <div class="mt-8 flex items-center">
                    <input type="checkbox" id="privacy" name="privacy" value="1" class="h-4 w-4 text-black border-gray-400 focus:ring-black" required>
                    <label for="privacy" class="ml-3 text-sm">
                        By checking this box, I agree to CHANEL's <a href="#" class="underline">Privacy Policy and Legal Statement</a>.
                    </label>
                </div>
                
                <button type="submit" class="mt-8 w-full bg-black text-white py-3 px-12 uppercase text-xs tracking-widest hover:bg-gray-800 transition-colors">
                    Confirm Order
                </button>
            </div>

            <div class="w-full mt-12 lg:mt-0">
                <div class="border-t border-b py-6">
                    <h2 class="text-sm font-semibold tracking-widest mb-4">ORDER SUMMARY</h2>
                    
                    @foreach($cart as $item)
                    <div class="flex items-center justify-between py-4">
                        <div class="flex items-start">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover mr-4">
                            <div>
                                <h3 class="font-bold uppercase text-sm">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $item['description'] ?? 'Product' }}</p>
                                <p class="text-sm text-gray-800 mt-1">QTY {{ $item['quantity'] ?? 1 }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="space-y-3 text-sm mt-6 border-t pt-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Taxes (10%)*</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Delivery</span>
                            <span>FREE</span>
                        </div>
                        <div class="flex justify-between font-bold text-base mt-4 pt-4 border-t">
                            <span>TOTAL</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">* Tax applied for orders over $200</p>
                </div>

                <div class="mt-8">
                    <h3 class="text-sm font-semibold tracking-widest mb-4">WRAPPING</h3>
                    <div class="flex items-center text-sm">
                        <img src="{{ asset('img/cl.webp') }}" alt="Wrapping" class="w-16 mr-4">
                        <div>
                            <h4 class="font-bold">THE CLASSIC</h4>
                            <p>Presented in a signature box or bag.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-sm font-semibold tracking-widest mb-4">PAYMENT METHODS</h3>
                    <div class="flex items-center space-x-4 text-gray-500 text-xs">
                        <span>VISA</span> <span>MASTERCARD</span> <span>DISCOVER</span> <span>AMEX</span> <span>PAYPAL</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-sm font-bold tracking-widest">SECURE PAYMENT</h4>
                        <p class="text-xs mt-1">Your credit card details are safe with us.<br>All information is protected using SSL technology.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
