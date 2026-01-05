@extends('layouts.frontend')

@section('content')
<!-- Title -->
<div class="container mx-auto px-4 py-12 text-center">
    <h1 class="text-5xl md:text-7xl font-black uppercase tracking-widest text-gray-900">Foundation <span>CHANEL</span></h1>
</div>

<!-- Promo Block -->
<div class="max-w-6xl mx-auto px-4 mt-12">
    <div class="flex flex-col md:flex-row items-center bg-gray-50">
        <div class="md:w-1/2">
            <img src="{{ asset('img/ab.webp') }}" alt="Foundation CHANEL" class="w-full h-full object-cover">
        </div>
        <div class="md:w-1/2 p-8 lg:p-16 text-left">
            <h2 class="text-xl lg:text-2xl font-bold uppercase tracking-wide">FOUNDATION CHANEL IS COMMITTED TO WOMEN AND ADOLESCENT GIRLS</h2>
            <p class="mt-4 text-gray-700">Since 2011, Fondation CHANEL has worked in solidarity with its not-for-profit partners to create conditions for women and girls to be free to shape their own destiny.</p>
            <p class="mt-4 text-gray-700">Through multi-year, specialised support, Fondation CHANEL adapts global strategies to local realities, offering tailored resources, connecting critical channels and amplifying community-led solutions.</p>
            <a href="#" class="inline-block mt-8 bg-black text-white py-3 px-10 uppercase text-sm font-bold tracking-widest hover:bg-gray-800 transition-colors">DISCOVER</a>
        </div>
    </div>
</div>

<!-- Support Section -->
<div class="max-w-6xl mx-auto px-4 py-20">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
        <!-- Contact an Advisor -->
        <div class="border-t-2 border-black pt-6">
            <h4 class="text-lg font-bold uppercase tracking-wider">Contact an Advisor</h4>
            <p class="mt-4 text-sm text-gray-600">CHANEL Client Care is available Monday to Sunday, 7 AM to 12 AM ET. to answer all your questions.</p>
            <p class="mt-4 text-sm text-gray-600">Please <a href="#" class="underline hover:text-gray-900">email us</a>, call <a href="#" class="underline hover:text-gray-900">1.800.550.0005</a> or live chat with a CHANEL Advisor.</p>
        </div>

        <!-- Find a Store -->
        <div class="border-t-2 border-black pt-6">
            <h4 class="text-lg font-bold uppercase tracking-wider">Find a Store</h4>
            <p class="mt-4 text-sm text-gray-600">Enter a location to find the closest CHANEL stores</p>
            <form class="mt-4">
                <div class="flex">
                    <input type="text" placeholder="City or zip code" class="grow p-3 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-black">
                    <button type="submit" class="bg-black text-white px-6 font-bold text-xl hover:bg-gray-800 transition-colors">→</button>
                </div>
            </form>
        </div>

        <!-- Newsletter -->
        <div class="border-t-2 border-black pt-6">
            <h4 class="text-lg font-bold uppercase tracking-wider">Newsletter</h4>
            <p class="mt-4 text-sm text-gray-600">Subscribe to receive news from CHANEL</p>
            <form class="mt-4">
                <div class="flex">
                    <input type="email" placeholder="Enter your email address" class="grow p-3 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-black">
                    <button type="submit" class="bg-black text-white px-6 font-bold text-xl hover:bg-gray-800 transition-colors">→</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
