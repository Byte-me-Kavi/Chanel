<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen p-4 bg-[#f8fafc] font-['Inter']">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-12">
            <div class="text-center">
                <h1 class="text-2xl font-bold uppercase tracking-[0.25em] mb-8 text-black"><a href="{{ url('/') }}">CHANEL</a></h1>
            </div>

            <!-- Tabs -->
            <div class="flex justify-center gap-8 mb-8 border-b border-gray-200">
                <button class="pb-4 font-bold uppercase tracking-widest text-black border-b-2 border-black">Login</button>
                <a href="{{ route('register') }}" class="pb-4 font-bold text-gray-400 uppercase tracking-widest border-b-2 border-transparent hover:text-black transition-colors">Sign Up</a>
            </div>

            <div class="mt-6">
                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="relative mb-6">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" /></svg>
                        </div>
                        <input id="email" class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email address" />
                    </div>

                    <div class="relative mb-6">
                         <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                        </div>
                        <input id="password" class="w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black focus:ring-1 focus:ring-black transition-all" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                    </div>

                    <div class="block mt-4 mb-6">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-3.5 rounded-lg font-bold uppercase tracking-wider hover:bg-gray-800 transition-colors">
                        {{ __('Log in') }}
                    </button>
                    
                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
