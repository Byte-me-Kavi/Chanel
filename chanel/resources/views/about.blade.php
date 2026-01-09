@extends('layouts.frontend')

@section('content')
<div class="py-12 px-4 text-center container mx-auto">
    <h1 class="text-5xl font-black text-gray-900 uppercase tracking-widest md:text-7xl">Foundation <span>CHANEL</span></h1>
</div>

<div class="px-4 mt-12 mx-auto max-w-6xl">
    <div class="flex flex-col items-center bg-gray-50 md:flex-row">
        <div class="md:w-1/2">
            <img src="{{ asset('img/ab.webp') }}" alt="Foundation CHANEL" class="object-cover w-full h-full">
        </div>
        <div class="p-8 text-left md:w-1/2 lg:p-16">
            <h2 class="text-xl font-bold uppercase tracking-wide lg:text-2xl">FOUNDATION CHANEL IS COMMITTED TO WOMEN AND ADOLESCENT GIRLS</h2>
            <p class="mt-4 text-gray-700">Since 2011, Fondation CHANEL has worked in solidarity with its not-for-profit partners to create conditions for women and girls to be free to shape their own destiny.</p>
            <p class="mt-4 text-gray-700">Through multi-year, specialised support, Fondation CHANEL adapts global strategies to local realities, offering tailored resources, connecting critical channels and amplifying community-led solutions.</p>
            <a href="#" class="inline-block px-10 py-3 mt-8 text-sm font-bold text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">DISCOVER</a>
        </div>
    </div>
</div>

<div class="py-20 px-4 mx-auto max-w-6xl">
    <div class="grid grid-cols-1 gap-8 text-left md:grid-cols-3">
        <div class="pt-6 border-t-2 border-black">
            <h4 class="text-lg font-bold uppercase tracking-wider">Client Care</h4>
            <p class="mt-4 text-sm text-gray-600">CHANEL Client Care is available Monday to Sunday, 7 AM to 12 AM ET. to answer all your questions.</p>
            <p class="mt-4 text-sm text-gray-600">Please <a href="#" class="underline hover:text-gray-900">email us</a>, call <a href="#" class="underline hover:text-gray-900">1.800.550.0005</a> or live chat with a CHANEL Advisor.</p>
        </div>

        <div class="pt-6 border-t-2 border-black">
            <h4 class="text-lg font-bold uppercase tracking-wider">Find a Store</h4>
            <p class="mt-4 text-sm text-gray-600">Enter a location to find the closest CHANEL stores</p>
            <form class="mt-4">
                <div class="flex">
                    <input type="text" placeholder="City or zip code" class="p-3 border border-gray-300 grow focus:outline-none focus:ring-1 focus:ring-black">
                    <button type="submit" class="px-6 text-xl font-bold text-white transition-colors bg-black hover:bg-gray-800">→</button>
                </div>
            </form>
        </div>

        <div class="pt-6 border-t-2 border-black">
            <h4 class="text-lg font-bold uppercase tracking-wider">Keep in Touch</h4>
            <p class="mt-4 text-sm text-gray-600">Subscribe to receive news from CHANEL</p>
            <form class="mt-4">
                <div class="flex">
                    <input type="email" placeholder="Enter your email address" class="p-3 border border-gray-300 grow focus:outline-none focus:ring-1 focus:ring-black">
                    <button type="submit" class="px-6 text-xl font-bold text-white transition-colors bg-black hover:bg-gray-800">→</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
