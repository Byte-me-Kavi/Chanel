@extends('layouts.frontend')

@section('content')
<section class="flex relative items-center justify-center text-center text-white bg-center bg-cover h-[70vh]" style="background-image: url('{{ asset('img/front cover.webp') }}');">
    <div class="p-8 bg-black/20">
        <h1 class="mb-4 text-4xl font-bold uppercase tracking-widest md:text-5xl">BLEU DE CHANEL L'EXCLUSIF</h1>
        <a href="#" class="inline-block px-8 py-3 text-sm font-bold uppercase transition-colors duration-300 border border-white tracking-widest hover:text-black hover:bg-white">Discover The New Fragrance</a>
    </div>
</section>

<div class="px-4 mx-auto max-w-[1400px] md:px-8">
    <section>
        <h2 class="my-16 text-2xl font-semibold text-center uppercase tracking-[0.2em]">Top Fragrances</h2>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

            <div class="group text-center">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/Blue de chanel.webp') }}" alt="Bleu de Chanel" class="block w-full h-auto transition-transform duration-500 group-hover:scale-105">
                    </div>
                </a>
                <h3 class="mt-4 text-base font-semibold uppercase">Bleu de Chanel</h3>
                <p class="mt-1 text-sm text-gray-500">Eau de Parfum</p>
                <p class="mt-2 font-bold">$165.00</p>
                <button class="px-6 py-2.5 mt-4 text-xs font-semibold tracking-wider text-black bg-white uppercase transition-colors duration-300 border border-black cursor-pointer inline-block hover:text-white hover:bg-black">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/chance eau tendre.webp') }}" alt="Chance Eau Tendre" class="block w-full h-auto transition-transform duration-500 group-hover:scale-105">
                    </div>
                </a>
                <h3 class="mt-4 text-base font-semibold uppercase">Chance Eau Tendre</h3>
                <p class="mt-1 text-sm text-gray-500">Eau de Toilette</p>
                <p class="mt-2 font-bold">$150.00</p>
                <button class="px-6 py-2.5 mt-4 text-xs font-semibold tracking-wider text-black bg-white uppercase transition-colors duration-300 border border-black cursor-pointer inline-block hover:text-white hover:bg-black">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/coco noir.webp') }}" alt="Coco Noir" class="block w-full h-auto transition-transform duration-500 group-hover:scale-105">
                    </div>
                </a>
                <h3 class="mt-4 text-base font-semibold uppercase">Coco Noir</h3>
                <p class="mt-1 text-sm text-gray-500">Eau de Parfum</p>
                <p class="mt-2 font-bold">$175.00</p>
                <button class="px-6 py-2.5 mt-4 text-xs font-semibold tracking-wider text-black bg-white uppercase transition-colors duration-300 border border-black cursor-pointer inline-block hover:text-white hover:bg-black">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/n05.webp') }}" alt="N°5" class="block w-full h-auto transition-transform duration-500 group-hover:scale-105">
                    </div>
                </a>
                <h3 class="mt-4 text-base font-semibold uppercase">N°5</h3>
                <p class="mt-1 text-sm text-gray-500">Eau de Parfum</p>
                <p class="mt-2 font-bold">$180.00</p>
                <button class="px-6 py-2.5 mt-4 text-xs font-semibold tracking-wider text-black bg-white uppercase transition-colors duration-300 border border-black cursor-pointer inline-block hover:text-white hover:bg-black">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/coco manem.webp') }}" alt="COCO MADEMOISELLE" class="block w-full h-auto transition-transform duration-500 group-hover:scale-105">
                    </div>
                </a>
                <h3 class="mt-4 text-base font-semibold uppercase">Coco Mademoiselle</h3>
                <p class="mt-1 text-sm text-gray-500">Eau de Parfum</p>
                <p class="mt-2 font-bold">$180.00</p>
                <button class="px-6 py-2.5 mt-4 text-xs font-semibold tracking-wider text-black bg-white uppercase transition-colors duration-300 border border-black cursor-pointer inline-block hover:text-white hover:bg-black">Add to Bag</button>
            </div>

            <div class="text-center group">
                <a href="#" class="block overflow-hidden bg-[#f5f5f5]">
                    <div class="overflow-hidden">
                        <img src="{{ asset('img/gabrielle chanel.webp') }}" alt="Gabrielle Chanel" class="block w-full h-auto transition-transform duration-500 group-hover:scale-105">
                    </div>
                </a>
                <h3 class="mt-4 text-base font-semibold uppercase">Gabrielle Chanel</h3>
                <p class="mt-1 text-sm text-gray-500">Eau de Parfum</p>
                <p class="mt-2 font-bold">$180.00</p>
                <button class="px-6 py-2.5 mt-4 text-xs font-semibold tracking-wider text-black bg-white uppercase transition-colors duration-300 border border-black cursor-pointer inline-block hover:text-white hover:bg-black">Add to Bag</button>
            </div>
            

        </div>
    </section>


    <div class="flex flex-col flex-wrap items-center gap-8 mx-auto mt-24 mb-24 md:flex-row-reverse max-w-[1000px]">
        <div class="flex-1 min-w-[300px]">
            <img src="{{ asset('img/img2.webp') }}" alt="Les Exclusifs de Chanel" class="block w-full h-auto">
        </div>
        <div class="flex-1 text-center min-w-[300px] md:text-left">
            <h4 class="mb-2 text-xs font-normal text-gray-500 uppercase tracking-widest">FRAGRANCE</h4>
            <h2 class="mb-4 text-2xl font-bold uppercase tracking-widest">LES EXCLUSIFS DE CHANEL</h2>
            <p class="mx-auto mb-6 leading-relaxed text-gray-800 md:mx-0 max-w-[450px]">A fragrance collection that embodies the House, named for a particular trait present throughout its history, without which none of its achievements would have been possible: temperament.</p>
            <a href="#" class="inline-block pb-0.5 text-xs font-bold uppercase transition-colors border-b border-black tracking-widest hover:text-gray-600">SHOP NOW</a>
        </div>
    </div>


    <div class="flex flex-col flex-wrap items-center gap-8 mx-auto mb-24 md:flex-row max-w-[1000px]">
        <div class="flex-1 min-w-[300px]">
            <img src="{{ asset('img/img1.webp') }}" alt="Coco Mademoiselle Fragrance Primer" class="block w-full h-auto">
        </div>
        <div class="flex-1 text-center min-w-[300px] md:text-left">
            <h4 class="mb-2 text-xs font-normal text-gray-500 uppercase tracking-widest">NEW</h4>
            <h2 class="mb-4 text-2xl font-bold uppercase tracking-widest">COCO MADEMOISELLE FRAGRANCE PRIMER</h2>
            <p class="mx-auto mb-6 leading-relaxed text-gray-800 md:mx-0 max-w-[450px]">A water-based body mist, featuring the sensual notes of COCO MADEMOISELLE, that prepares skin for fragrance application.</p>
            <a href="#" class="inline-block pb-0.5 text-xs font-bold uppercase transition-colors border-b border-black tracking-widest hover:text-gray-600">DISCOVER</a>
        </div>
    </div>



    <section class="mb-24">
        <h2 class="mb-12 text-2xl font-semibold text-center uppercase tracking-[0.2em]">Categories</h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <a href="#" class="relative block h-[300px] overflow-hidden text-center text-white group">
                <img src="{{ asset('img/women.webp') }}" alt="Women" class="object-cover w-full h-full transition-transform duration-500 brightness-75 group-hover:scale-105">
                <div class="absolute text-xl font-bold uppercase -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 tracking-widest">Women</div>
            </a>
            <a href="#" class="relative block h-[300px] overflow-hidden text-center text-white group">
                <img src="{{ asset('img/men.webp') }}" alt="Men" class="object-cover w-full h-full transition-transform duration-500 brightness-75 group-hover:scale-105">
                <div class="absolute text-xl font-bold uppercase -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 tracking-widest">Men</div>
            </a>
             <a href="#" class="relative block h-[300px] overflow-hidden text-center text-white group">
                <img src="{{ asset('img/les eaux.webp') }}" alt="Les Exclusifs" class="object-cover w-full h-full transition-transform duration-500 brightness-75 group-hover:scale-105">
                <div class="absolute text-xl font-bold uppercase -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 tracking-widest">Les Exclusifs</div>
            </a>
             <a href="#" class="relative block h-[300px] overflow-hidden text-center text-white group">
                <img src="{{ asset('img/les.webp') }}" alt="Les Eaux" class="object-cover w-full h-full transition-transform duration-500 brightness-75 group-hover:scale-105">
                <div class="absolute text-xl font-bold uppercase -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 tracking-widest">Les Eaux</div>
            </a>
        </div>
    </section>



    <div class="grid grid-cols-1 gap-12 mb-24 md:grid-cols-2">
        <div class="text-center">
            <img src="{{ asset('img/sig.webp') }}" alt="Signature Presentation" class="max-w-full h-auto mx-auto mb-6">
            <h3 class="mb-2 text-lg font-bold uppercase tracking-widest">SIGNATURE PRESENTATION</h3>
            <p class="text-sm text-gray-600 leading-relaxed max-w-[400px] mx-auto mb-6">CHANEL now presents each purchase in recyclable, reusable packaging.</p>
            <a href="#" class="inline-block pb-0.5 text-xs font-bold uppercase transition-colors border-b border-black tracking-widest hover:text-gray-600">DISCOVER</a>
        </div>
        <div class="text-center">
            <img src="{{ asset('img/le.webp') }}" alt="Le Quart D'Heure Alchimique" class="max-w-full h-auto mx-auto mb-6">
            <h3 class="mb-2 text-lg font-bold uppercase tracking-widest">LE QUART D'HEURE ALCHIMIQUE</h3>
            <p class="text-sm text-gray-600 leading-relaxed max-w-[400px] mx-auto mb-6">A complimentary 15-minute fragrance experience that reveals your allure and helps you find your signature CHANEL scent.</p>
            <a href="#" class="inline-block pb-0.5 text-xs font-bold uppercase transition-colors border-b border-black tracking-widest hover:text-gray-600">LEARN MORE</a>
        </div>
    </div>
</div>
@endsection
