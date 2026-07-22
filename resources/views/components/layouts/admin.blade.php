@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin - Ehsan Electronics' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|outfit:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-teal-950 text-white flex-shrink-0">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-lg font-bold leading-tight">
                    Ehsan Electronics
                    <span class="mt-1 block text-xs font-sans font-medium text-amber-400">Admin Panel</span>
                </a>
            </div>
            <nav class="mt-4 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900' }}">Products</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900' }}">Categories</a>
                <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900' }}">Orders</a>
                <hr class="border-teal-800 my-4">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-teal-200 hover:bg-teal-900">View Store</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-teal-200 hover:bg-teal-900">Logout</button>
                </form>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            <x-flash-messages />
            {{ $slot }}
        </main>
    </div>
</body>
</html>
