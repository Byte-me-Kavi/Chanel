@extends('layouts.frontend')

@section('content')
<section class="relative h-[70vh] bg-cover bg-center flex items-center justify-center text-center text-white" style="background-image: url('{{ asset('img/front cover.webp') }}');">
    <div class="bg-black/20 p-8">
        <h1 class="text-4xl md:text-5xl mb-4 tracking-widest uppercase font-bold">BLEU DE CHANEL L'EXCLUSIF</h1>
        <a href="#" class="inline-block px-8 py-3 border border-white uppercase tracking-widest hover:bg-white hover:text-black transition-colors duration-300 font-bold text-sm">Discover The New Fragrance</a>
    </div>
</section>

<div class="max-w-[1400px] mx-auto px-4 md:px-8">
    <section>
        <h2 class="text-center text-2xl font-semibold tracking-[0.2em] uppercase my-16">Fragrance Bestsellers</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/Blue de chanel.webp') }}" alt="Bleu de Chanel" class="w-full h-auto block group-hover:scale-105 transition-transform duration-500">
                    </div>
                </a>
                <h3 class="mt-4 font-semibold uppercase text-base">Bleu de Chanel</h3>
                <p class="text-sm text-gray-500 mt-1">Eau de Parfum</p>
                <p class="mt-2 font-bold">$165.00</p>
                <button class="inline-block mt-4 px-6 py-2.5 border border-black bg-white text-black font-semibold uppercase hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer text-xs tracking-wider">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/chance eau tendre.webp') }}" alt="Chance Eau Tendre" class="w-full h-auto block group-hover:scale-105 transition-transform duration-500">
                    </div>
                </a>
                <h3 class="mt-4 font-semibold uppercase text-base">Chance Eau Tendre</h3>
                <p class="text-sm text-gray-500 mt-1">Eau de Toilette</p>
                <p class="mt-2 font-bold">$150.00</p>
                <button class="inline-block mt-4 px-6 py-2.5 border border-black bg-white text-black font-semibold uppercase hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer text-xs tracking-wider">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/coco noir.webp') }}" alt="Coco Noir" class="w-full h-auto block group-hover:scale-105 transition-transform duration-500">
                    </div>
                </a>
                <h3 class="mt-4 font-semibold uppercase text-base">Coco Noir</h3>
                <p class="text-sm text-gray-500 mt-1">Eau de Parfum</p>
                <p class="mt-2 font-bold">$175.00</p>
                <button class="inline-block mt-4 px-6 py-2.5 border border-black bg-white text-black font-semibold uppercase hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer text-xs tracking-wider">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/n05.webp') }}" alt="N°5" class="w-full h-auto block group-hover:scale-105 transition-transform duration-500">
                    </div>
                </a>
                <h3 class="mt-4 font-semibold uppercase text-base">N°5</h3>
                <p class="text-sm text-gray-500 mt-1">Eau de Parfum</p>
                <p class="mt-2 font-bold">$180.00</p>
                <button class="inline-block mt-4 px-6 py-2.5 border border-black bg-white text-black font-semibold uppercase hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer text-xs tracking-wider">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/coco manem.webp') }}" alt="COCO MADEMOISELLE" class="w-full h-auto block group-hover:scale-105 transition-transform duration-500">
                    </div>
                </a>
                <h3 class="mt-4 font-semibold uppercase text-base">Coco Mademoiselle</h3>
                <p class="text-sm text-gray-500 mt-1">Eau de Parfum</p>
                <p class="mt-2 font-bold">$180.00</p>
                <button class="inline-block mt-4 px-6 py-2.5 border border-black bg-white text-black font-semibold uppercase hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer text-xs tracking-wider">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/gabrielle chanel.webp') }}" alt="Gabrielle Chanel" class="w-full h-auto block group-hover:scale-105 transition-transform duration-500">
                    </div>
                </a>
                <h3 class="mt-4 font-semibold uppercase text-base">Gabrielle Chanel</h3>
                <p class="text-sm text-gray-500 mt-1">Eau de Parfum</p>
                <p class="mt-2 font-bold">$180.00</p>
                <button class="inline-block mt-4 px-6 py-2.5 border border-black bg-white text-black font-semibold uppercase hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer text-xs tracking-wider">Add to Bag</button>
            </div>
            

        </div>
    </section>


    <div class="flex flex-col md:flex-row-reverse flex-wrap gap-8 items-center mb-24 max-w-[1000px] mx-auto mt-24">
        <div class="flex-1 min-w-[300px]">
            <img src="{{ asset('img/img2.webp') }}" alt="Les Exclusifs de Chanel" class="w-full h-auto block">
        </div>
        <div class="flex-1 min-w-[300px] text-center md:text-left">
            <h4 class="text-xs font-normal uppercase tracking-widest mb-2 text-gray-500">FRAGRANCE</h4>
            <h2 class="text-2xl font-bold uppercase tracking-widest mb-4">LES EXCLUSIFS DE CHANEL</h2>
            <p class="leading-relaxed text-gray-800 mb-6 max-w-[450px] mx-auto md:mx-0">A fragrance collection that embodies the House, named for a particular trait present throughout its history, without which none of its achievements would have been possible: temperament.</p>
            <a href="#" class="inline-block font-bold uppercase tracking-widest border-b border-black pb-0.5 hover:text-gray-600 transition-colors text-xs">SHOP NOW</a>
        </div>
    </div>


    <div class="flex flex-col md:flex-row flex-wrap gap-8 items-center mb-24 max-w-[1000px] mx-auto">
        <div class="flex-1 min-w-[300px]">
            <img src="{{ asset('img/img1.webp') }}" alt="Coco Mademoiselle Fragrance Primer" class="w-full h-auto block">
        </div>
        <div class="flex-1 min-w-[300px] text-center md:text-left">
            <h4 class="text-xs font-normal uppercase tracking-widest mb-2 text-gray-500">NEW</h4>
            <h2 class="text-2xl font-bold uppercase tracking-widest mb-4">COCO MADEMOISELLE FRAGRANCE PRIMER</h2>
            <p class="leading-relaxed text-gray-800 mb-6 max-w-[450px] mx-auto md:mx-0">A water-based body mist, featuring the sensual notes of COCO MADEMOISELLE, that prepares skin for fragrance application.</p>
            <a href="#" class="inline-block font-bold uppercase tracking-widest border-b border-black pb-0.5 hover:text-gray-600 transition-colors text-xs">DISCOVER</a>
        </div>
    </div>



    <section class="mb-24">
        <h2 class="text-center text-2xl font-semibold tracking-[0.2em] uppercase mb-12">Shop By Category</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="#" class="relative text-center text-white block group overflow-hidden h-[300px]">
                <img src="{{ asset('img/women.webp') }}" alt="Women" class="w-full h-full object-cover brightness-75 group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xl font-bold uppercase tracking-widest">Women</div>
            </a>
            <a href="#" class="relative text-center text-white block group overflow-hidden h-[300px]">
                <img src="{{ asset('img/men.webp') }}" alt="Men" class="w-full h-full object-cover brightness-75 group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xl font-bold uppercase tracking-widest">Men</div>
            </a>
             <a href="#" class="relative text-center text-white block group overflow-hidden h-[300px]">
                <img src="{{ asset('img/les eaux.webp') }}" alt="Les Exclusifs" class="w-full h-full object-cover brightness-75 group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xl font-bold uppercase tracking-widest">Les Exclusifs</div>
            </a>
             <a href="#" class="relative text-center text-white block group overflow-hidden h-[300px]">
                <img src="{{ asset('img/les.webp') }}" alt="Les Eaux" class="w-full h-full object-cover brightness-75 group-hover:scale-105 transition-transform duration-500">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xl font-bold uppercase tracking-widest">Les Eaux</div>
            </a>
        </div>
    </section>



    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-24">
        <div class="text-center">
            <img src="{{ asset('img/sig.webp') }}" alt="Signature Presentation" class="max-w-full h-auto mb-6 mx-auto">
            <h3 class="text-lg font-bold uppercase tracking-widest mb-2">SIGNATURE PRESENTATION</h3>
            <p class="text-sm text-gray-600 leading-relaxed max-w-[400px] mx-auto mb-6">CHANEL now presents each purchase in recyclable, reusable packaging.</p>
            <a href="#" class="inline-block font-bold uppercase tracking-widest border-b border-black pb-0.5 hover:text-gray-600 transition-colors text-xs">DISCOVER</a>
        </div>
        <div class="text-center">
            <img src="{{ asset('img/le.webp') }}" alt="Le Quart D'Heure Alchimique" class="max-w-full h-auto mb-6 mx-auto">
            <h3 class="text-lg font-bold uppercase tracking-widest mb-2">LE QUART D'HEURE ALCHIMIQUE</h3>
            <p class="text-sm text-gray-600 leading-relaxed max-w-[400px] mx-auto mb-6">A complimentary 15-minute fragrance experience that reveals your allure and helps you find your signature CHANEL scent.</p>
            <a href="#" class="inline-block font-bold uppercase tracking-widest border-b border-black pb-0.5 hover:text-gray-600 transition-colors text-xs">LEARN MORE</a>
        </div>
    </div>
</div>
@endsection
