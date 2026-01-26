@extends('layouts.frontend')

@section('content')
<div class="px-4 mx-auto container sm:px-6 lg:px-8">
    <h1 class="my-12 text-3xl font-light text-center uppercase lg:text-4xl tracking-[0.2em]">Secure Checkout</h1>

    <div id="checkout-form-container">
        <form id="checkout-form" onsubmit="submitOrder(event)">
            <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-16">
                <div class="lg:col-span-2">
                    <p class="mb-6 text-sm">Continue as a guest or log in to your personal account.</p>
                    
                    @auth
                    <p class="mb-6 text-sm text-gray-700">Logged in as <strong>{{ Auth::user()->name }}</strong></p>
                    @else
                    <a href="{{ route('login') }}" class="inline-block px-12 py-3 mb-6 text-xs font-bold text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">Login to Continue</a>
                    <p class="text-xs text-red-500 mb-6">You must be logged in to checkout via API.</p>
                    @endauth
    
                    <div class="mt-12">
                        <h2 class="text-sm font-semibold tracking-widest">DELIVERY METHOD</h2>
                        <hr class="mt-3 mb-6 border-black">
                        
                        <select name="delivery_method" id="delivery_method" required class="p-3 w-full text-sm border border-gray-300 focus:outline-none focus:ring-1 focus:ring-black">
                            <option value="Standard Shipping">Standard Shipping</option>
                            <option value="Express Shipping">Express Shipping</option>
                            <option value="Same-Day or Next-Day Delivery">Same-Day or Next-Day Delivery</option>
                            <option value="In-Store Pickup (Click and Collect)">In-Store Pickup (Click and Collect)</option>
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
                    
                    <div id="error-message" class="hidden mt-4 text-red-600 text-sm"></div>

                    <button type="submit" class="px-12 py-3 mt-8 w-full text-xs font-bold text-white uppercase transition-colors bg-black tracking-widest hover:bg-gray-800">
                        Confirm Order
                    </button>
                </div>
    
                <div class="mt-12 w-full lg:mt-0">
                    <div class="py-6 border-t border-b">
                        <h2 class="mb-4 text-sm font-semibold tracking-widest">YOUR ORDER</h2>
                        
                        <div id="order-items">
                            <!-- Items -->
                        </div>
                        
                        <div class="pt-4 mt-6 text-sm space-y-3 border-t">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>$<span id="c-subtotal">0.00</span></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Taxes (10%)*</span>
                                <span>$<span id="c-tax">0.00</span></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Delivery</span>
                                <span>FREE</span>
                            </div>
                            <div class="flex justify-between pt-4 mt-4 text-base font-bold border-t">
                                <span>TOTAL</span>
                                <span>$<span id="c-total">0.00</span></span>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">* Tax applied for orders over $200</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        renderOrderSummary();
    });

    function renderOrderSummary() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const container = document.getElementById('order-items');
        
        if (cart.length === 0) {
            window.location.href = '/cart'; // Redirect if empty
            return;
        }

        let subtotal = 0;
        container.innerHTML = '';

        cart.forEach(item => {
            subtotal += parseFloat(item.price);
            const html = `
            <div class="flex justify-between items-center py-4">
                <div class="flex items-start">
                    <img src="${item.image}" alt="${item.name}" class="mr-4 w-20 h-20 object-cover">
                    <div>
                        <h3 class="text-sm font-bold uppercase">${item.name}</h3>
                        <p class="mt-1 text-sm text-gray-800">QTY 1</p>
                    </div>
                </div>
                <div>$${parseFloat(item.price).toFixed(2)}</div>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
        });

        const tax = subtotal > 200 ? subtotal * 0.10 : 0;
        const total = subtotal + tax;

        document.getElementById('c-subtotal').innerText = subtotal.toFixed(2);
        document.getElementById('c-tax').innerText = tax.toFixed(2);
        document.getElementById('c-total').innerText = total.toFixed(2);
    }

    function submitOrder(e) {
        e.preventDefault();
        
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if(cart.length === 0) return;

        const delivery = document.getElementById('delivery_method').value;
        const privacy = document.getElementById('privacy').checked;

        if(!privacy) {
            alert('Please accept terms.');
            return;
        }

        fetch('/api/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                items: cart,
                delivery_method: delivery,
                wrapping: false, // Could add input
                gift_message: '' // Could add input
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                localStorage.removeItem('cart');
                window.location.href = '/checkout/success';
            } else {
                document.getElementById('error-message').innerText = data.message || 'Error processing order.';
                document.getElementById('error-message').classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('error-message').innerText = 'System error. Please try again.';
            document.getElementById('error-message').classList.remove('hidden');
        });
    }
</script>
@endsection
