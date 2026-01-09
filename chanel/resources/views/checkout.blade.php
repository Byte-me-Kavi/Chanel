@extends('layouts.frontend')

@section('content')
<div class="px-4 mx-auto container sm:px-6 lg:px-8">
    <h1 class="my-12 text-3xl font-light text-center uppercase lg:text-4xl tracking-[0.2em]">Secure Checkout</h1>

    @if(session('error'))
    <div class="p-4 mb-6 text-center text-red-800 bg-red-100 rounded">
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-16">
            <div class="lg:col-span-2">
                <p class="mb-6 text-sm">Continue as a guest or log in to your personal account.</p>
                
                @auth
                <p class="mb-6 text-sm text-gray-700">Logged in as <strong>{{ Auth::user()->name }}</strong></p>
                @else
                <a href="{{ route('login') }}" class="inline-block px-12 py-3 mb-6 text-xs font-bold text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">Login to Continue</a>
                @endauth

                <div class="mt-12">
                    <h2 class="text-sm font-semibold tracking-widest">DELIVERY METHOD</h2>
                    <hr class="mt-3 mb-6 border-black">
                    
                    <select name="delivery_method" required class="p-3 w-full text-sm border border-gray-300 focus:outline-none focus:ring-1 focus:ring-black">
                        @foreach($deliveryMethods as $method)
                        <option value="{{ $method }}">{{ $method }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-12">
                    <h2 class="text-sm font-semibold tracking-widest">PAYMENT OPTIONS</h2>
                    <hr class="mt-3 mb-6 border-black">
                    <p class="text-sm text-gray-500">Payment integration would appear here.</p>
                </div>
                
                <div class="flex items-center mt-8">
                    <input type="checkbox" id="privacy" name="privacy" value="1" class="w-4 h-4 text-black border-gray-400 focus:ring-black" required>
                    <label for="privacy" class="ml-3 text-sm">
                        By checking this box, I agree to CHANEL's <a href="#" class="underline">Privacy Policy and Legal Statement</a>.
                    </label>
                </div>
                
                <button type="submit" class="px-12 py-3 mt-8 w-full text-xs font-bold text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">
                    Confirm Order
                </button>
            </div>

            <div class="mt-12 w-full lg:mt-0">
                <div class="py-6 border-t border-b">
                    <h2 class="mb-4 text-sm font-semibold tracking-widest">YOUR ORDER</h2>
                    
                    @foreach($cart as $item)
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-start">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="mr-4 w-20 h-20 object-cover">
                            <div>
                                <h3 class="text-sm font-bold uppercase">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $item['description'] ?? 'Product' }}</p>
                                <p class="mt-1 text-sm text-gray-800">QTY {{ $item['quantity'] ?? 1 }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="pt-4 mt-6 text-sm space-y-3 border-t">
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
                        <div class="flex justify-between pt-4 mt-4 text-base font-bold border-t">
                            <span>TOTAL</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">* Tax applied for orders over $200</p>
                </div>

                <div class="mt-8">
                    <h3 class="mb-4 text-sm font-semibold tracking-widest">WRAPPING</h3>
                    <div class="flex items-center text-sm">
                        <img src="{{ asset('img/cl.webp') }}" alt="Wrapping" class="mr-4 w-16">
                        <div>
                            <h4 class="font-bold">THE CLASSIC</h4>
                            <p>Presented in a signature box or bag.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="mb-4 text-sm font-semibold tracking-widest">ACCEPTED CARDS</h3>
                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                        <span>VISA</span> <span>MASTERCARD</span> <span>DISCOVER</span> <span>AMEX</span> <span>PAYPAL</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-sm font-bold tracking-widest">PAYMENT SECURITY</h4>
                        <p class="mt-1 text-xs">Your credit card details are safe with us.<br>All information is protected using SSL technology.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
