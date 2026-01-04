<header class="border-b border-gray-200">
    <div class="py-4">
        <div class="max-w-[1600px] mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="hidden lg:block w-[160px]"></div>
                <a href="{{ url('/') }}" class="text-4xl font-bold tracking-[0.25em] text-center text-black no-underline uppercase">CHANEL</a>
                <div class="flex items-center gap-6">
                    <a href="{{ route('search') }}" aria-label="Search" class="text-black hover:opacity-60 transition-opacity">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" /></svg>
                    </a>
                    @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-black hover:opacity-60 transition-opacity">
                            <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" /></svg>
                            <span class="hidden sm:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Dashboard
                            </a>
                            @else
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                My Orders
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" aria-label="Account" class="text-black hover:opacity-60 transition-opacity">
                         <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" /></svg>
                    </a>
                    @endauth
                    @auth
                    <a href="{{ route('wishlist.index') }}" aria-label="Wishlist" class="text-black hover:opacity-60 transition-opacity">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>
                    </a>
                    @else
                    <a href="{{ route('login') }}" aria-label="Wishlist" class="text-black hover:opacity-60 transition-opacity">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>
                    </a>
                    @endauth
                    
                    <a href="{{ route('cart.index') }}" class="relative text-black hover:opacity-60 transition-opacity" aria-label="Shopping Bag">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M12,2A3,3 0 0,0 9,5V7H15V5A3,3 0 0,0 12,2M9,8A1,1 0 0,0 8,9V11H6V9A3,3 0 0,1 9,6H15A3,3 0 0,1 18,9V11H16V9A1,1 0 0,0 15,8H9M18,12H6C4.89,12 4,12.9 4,14V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V14C20,12.9 19.1,12 18,12Z" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden md:block border-t border-b border-gray-200">
        <nav class="max-w-[1400px] mx-auto px-4">
            <ul class="flex justify-center items-center gap-8">
                <li><a href="{{ url('/') }}" class="block py-4 text-[13px] font-semibold uppercase tracking-[1px] hover:underline relative group">Home <span class="absolute bottom-3 left-0 w-full h-px bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span></a></li>
                <li><a href="{{ route('product') }}" class="block py-4 text-[13px] font-semibold uppercase tracking-[1px] hover:underline relative group">Product <span class="absolute bottom-3 left-0 w-full h-px bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span></a></li>
                <li><a href="{{ route('exclusives') }}" class="block py-4 text-[13px] font-semibold uppercase tracking-[1px] hover:underline relative group">Exclusives <span class="absolute bottom-3 left-0 w-full h-px bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span></a></li>
                <li><a href="{{ route('about') }}" class="block py-4 text-[13px] font-semibold uppercase tracking-[1px] hover:underline relative group">ABOUT CHANEL <span class="absolute bottom-3 left-0 w-full h-px bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span></a></li>
            </ul>
        </nav>
    </div>
</header>
