@extends('layouts.frontend')

@section('content')
<div class="container mx-auto px-4 text-center py-20">
    <div class="max-w-lg mx-auto">
        <div class="text-6xl mb-6">✅</div>
        <h1 class="text-3xl font-light mb-4">Thank You!</h1>
        <h2 class="text-xl mb-4">Your order has been placed.</h2>
        <p class="text-gray-600 mb-8">You will receive a confirmation email shortly.</p>
        <a href="{{ route('product') }}" class="inline-block bg-black text-white py-3 px-12 uppercase text-xs tracking-widest hover:bg-gray-800 transition-colors">
            Continue Shopping
        </a>
    </div>
</div>
@endsection
