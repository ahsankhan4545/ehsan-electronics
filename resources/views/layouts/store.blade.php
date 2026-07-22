<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Shop') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data>
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">Ehsan Electronics</a>
                    <div class="hidden md:flex gap-6">
                        <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">Home</a>
                        <a href="{{ route('shop.index') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">Shop</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-indigo-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if (($cartItemCount ?? 0) > 0)
                            <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $cartItemCount }}</span>
                        @endif
                    </a>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Admin</a>
                        @endif
                        <a href="{{ route('orders.index') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Orders</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @if (isset($header))
            <div class="bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <x-flash-messages />
            {{ $slot }}
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-lg font-semibold text-white mb-2">Ehsan Electronics</p>
            <p class="text-sm">&copy; {{ date('Y') }} Ehsan Electronics. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
