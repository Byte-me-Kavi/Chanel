<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CHANEL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold tracking-[0.25em]">CHANEL</h1>
            <p class="text-sm text-gray-500 mt-2">Admin Panel</p>
        </div>

        @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-center text-sm">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                <input type="email" name="email" id="email" required 
                       class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" required 
                       class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-black">
            </div>
            <button type="submit" class="w-full bg-black text-white py-3 uppercase tracking-widest hover:bg-gray-800 transition-colors">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="{{ url('/') }}" class="underline hover:no-underline">← Back to Store</a>
        </p>
    </div>
</body>
</html>
