@extends('layouts.frontend')

@section('content')
<div class="px-4 mx-auto my-12 max-w-5xl">
    <h1 class="text-4xl font-light text-center tracking-widest">Your Selection</h1>
    <h2 class="mt-2 text-sm font-normal text-center text-gray-600">CHANEL presents each purchase in signature packaging</h2>

    @if(session('success'))
    <div class="p-3 mt-4 text-center text-green-800 bg-green-100 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="mt-10">
        @if(count($cart) > 0)
            @foreach($cart as $index => $item)
            <div class="flex justify-between items-center py-4 border-b border-gray-200">
                <div class="flex gap-4 items-center">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="object-cover w-20 h-20 rounded">
                    <div>
                        <span class="text-lg font-medium">{{ $item['name'] }}</span>
                    </div>
                </div>
                <div class="flex gap-8 items-center">
                    <span class="text-base font-medium">${{ number_format($item['price'], 2) }}</span>
                    <form action="{{ route('cart.remove', $index) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-red-700 uppercase transition-colors hover:underline tracking-wider">Remove</button>
                    </form>
                </div>
            </div>
            @endforeach

            <div class="mt-8 text-xl font-bold text-right">Total: ${{ number_format($total, 2) }}</div>

            <div class="mt-16">
                <h2 class="text-lg font-bold uppercase tracking-wider">Wrapping Choices</h2>
                <hr class="mt-2 mb-6 border-0 border-t border-black">
                <div class="space-y-4">
                    <div class="p-5 border border-black cursor-pointer option-box">
                        <label class="flex items-start">
                            <input type="radio" name="wrap" checked class="mt-5 mr-5 w-5 h-5 accent-black">
                            <div class="flex justify-between items-start grow">
                                <div class="flex items-start">
                                    <img src="{{ asset('img/es.webp') }}" alt="The Essential" class="mr-5 w-20">
                                    <div>
                                        <div class="font-bold uppercase">THE ESSENTIAL</div>
                                        <div class="mt-1 max-w-lg text-gray-700">An organic cotton pouch placed directly in a shipping box. This option is not available for Click & Collect.</div>
                                        <a href="#" class="inline-block mt-2 text-sm text-gray-600 underline">Learn more</a>
                                    </div>
                                </div>
                                <div class="font-bold">COMPLIMENTARY</div>
                            </div>
                        </label>
                    </div>
                    <div class="p-5 border border-gray-300 cursor-pointer option-box">
                        <label class="flex items-start">
                            <input type="radio" name="wrap" class="mt-5 mr-5 w-5 h-5 accent-black">
                            <div class="flex justify-between items-start grow">
                                <div class="flex items-start">
                                    <img src="{{ asset('img/cl.webp') }}" alt="The Classic" class="mr-5 w-20">
                                    <div>
                                        <div class="font-bold uppercase">THE CLASSIC</div>
                                        <div class="mt-1 max-w-lg text-gray-700">Presented in a signature black-and-white box or bag.</div>
                                        <a href="#" class="inline-block mt-2 text-sm text-gray-600 underline">Learn more</a>
                                    </div>
                                </div>
                                <div class="font-bold">COMPLIMENTARY</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-8 mt-16 mx-auto max-w-4xl bg-gray-50">
                <h3 class="font-bold uppercase tracking-wider">Gift Note</h3>
                <hr class="mt-2 mb-5 border-0 border-t border-black">
                <p class="mb-6 max-w-3xl text-gray-700">Add a personal touch with a complimentary gift message. Choose to receive a blank card with your purchase, or write your message here and receive it printed.</p>
                <form class="space-y-3">
                    <label class="flex items-center cursor-pointer"><input type="radio" name="gift" checked class="mr-3 w-4 h-4 accent-black">Do not include a card</label>
                    <label class="flex items-center cursor-pointer"><input type="radio" name="gift" class="mr-3 w-4 h-4 accent-black">Include a blank card</label>
                    <label class="flex items-center cursor-pointer"><input type="radio" name="gift" class="mr-3 w-4 h-4 accent-black">Write a message</label>
                </form>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('checkout.index') }}" class="inline-block px-8 py-3 text-base text-white bg-black rounded-sm uppercase transition-colors hover:bg-gray-800 tracking-wider">Checkout</a>
            </div>

        @else
            <div class="py-12 text-center">
                <div class="text-lg text-gray-500">Your bag is empty.</div>
            </div>
        @endif
    </div>

    <div class="my-8 text-center">
        <a href="{{ route('product') }}" class="inline-block px-8 py-4 text-base font-bold text-center text-white uppercase rounded-md border-none transition-transform bg-linear-to-r from-black to-gray-700 hover:scale-105 tracking-wider">Continue Shopping</a>
    </div>
</div>

<div class="px-5 py-10 mt-10 text-center bg-gray-100">
    <div class="mx-auto max-w-5xl">
        <h2 class="mb-5 text-xl font-bold tracking-wider">Accepted Cards</h2>
        <div class="flex flex-wrap justify-center gap-4 items-center mb-8">
            <img src="{{ asset('img/visa.png') }}" alt="Visa" class="object-contain p-1 h-8 bg-white border border-gray-300 rounded">
            <img src="{{ asset('img/am.png') }}" alt="American Express" class="object-contain p-1 h-8 bg-white border border-gray-300 rounded">
            <img src="{{ asset('img/mas.png') }}" alt="MasterCard" class="object-contain p-1 h-8 bg-white border border-gray-300 rounded">
            <img src="{{ asset('img/dis.png') }}" alt="Discover" class="object-contain p-1 h-8 bg-white border border-gray-300 rounded">
        </div>
        <div>
            <h3 class="mb-2 text-base font-bold">Secure Payment</h3>
            <p class="text-sm text-gray-700">Your credit card details are safe with us.</p>
            <p class="my-1 text-sm text-gray-700">All the information is protected using Secure Sockets Layer (SSL) technology.</p>
            <a href="#" class="inline-block mt-3 text-sm text-black underline">Privacy Policy</a>
        </div>
    </div>
</div>
@endsection
