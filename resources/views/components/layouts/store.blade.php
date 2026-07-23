@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#fed700">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Ehsan Electronics">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/icon-192.png') }}">
    <title>{{ $title ?? config('app.name', 'Ehsan Electronics') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=oswald:500,600,700|source-sans-3:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { padding-top: env(safe-area-inset-top); padding-bottom: env(safe-area-inset-bottom); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-white text-mc-dark" x-data="{ mobileNav: false, departmentsOpen: false, showInstall: false }"
      x-init="
        try {
          const dismissed = localStorage.getItem('ee_install_dismissed');
          const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
          const isMobile = window.matchMedia('(max-width: 768px)').matches;
          showInstall = !dismissed && !isStandalone && isMobile;
        } catch (e) { showInstall = false; }
      ">

    {{-- Top bar --}}
    <div class="bg-mc-darker text-xs text-white/80">
        <div class="mx-auto flex max-w-store items-center justify-between px-4 py-2">
            <p class="hidden sm:block">Welcome to <span class="font-semibold text-mc-yellow">Ehsan Electronics</span> — Pakistan</p>
            <p class="sm:hidden text-mc-yellow font-semibold">Ehsan Electronics</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('mobile') }}" class="hover:text-mc-yellow font-semibold text-mc-yellow">Get App</a>
                @auth
                    <span class="hidden md:inline">Hi, {{ auth()->user()->name }}</span>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-mc-yellow">Admin</a>
                    @endif
                    <a href="{{ route('notifications.index') }}" class="hover:text-mc-yellow">
                        Messages
                        @if (($unreadNotifications ?? 0) > 0)
                            <span class="ml-1 rounded bg-mc-yellow px-1.5 py-0.5 text-[10px] font-bold text-mc-dark">{{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}</span>
                        @endif
                    </a>
                    <a href="{{ route('orders.index') }}" class="hover:text-mc-yellow">My Orders</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-mc-yellow">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-mc-yellow">Login</a>
                    <a href="{{ route('register') }}" class="hover:text-mc-yellow">Register</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Main header: logo + search + cart --}}
    <header class="border-b border-mc-border bg-white">
        <div class="mx-auto flex max-w-store flex-col gap-4 px-4 py-5 lg:flex-row lg:items-center lg:gap-8">
            <a href="{{ route('home') }}" class="shrink-0 text-center lg:text-left">
                <span class="font-display text-3xl font-bold uppercase tracking-wide text-mc-dark">
                    Ehsan <span class="text-mc-yellow drop-shadow-[0_1px_0_#333]">Electronics</span>
                </span>
                <span class="mt-0.5 block text-[11px] font-medium uppercase tracking-[0.2em] text-mc-muted">Media Center Style Store</span>
            </a>

            <form action="{{ route('shop.index') }}" method="GET" class="flex flex-1 overflow-hidden rounded-sm border-2 border-mc-yellow">
                <select name="category" class="hidden border-0 bg-mc-soft text-sm text-mc-dark focus:ring-0 sm:block">
                    <option value="">All Categories</option>
                    @foreach (($navCategories ?? collect()) as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="search" placeholder="Search for products..."
                       class="min-w-0 flex-1 border-0 px-4 text-sm focus:ring-0">
                <button type="submit" class="bg-mc-yellow px-5 text-sm font-bold uppercase tracking-wide text-mc-dark hover:bg-mc-yellow-dark">
                    Search
                </button>
            </form>

            <div class="flex items-center justify-center gap-5 lg:justify-end">
                <a href="{{ route('cart.index') }}" class="group flex items-center gap-3">
                    <span class="relative flex h-12 w-12 items-center justify-center rounded-full bg-mc-soft text-mc-dark transition group-hover:bg-mc-yellow">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if (($cartItemCount ?? 0) > 0)
                            <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-mc-dark px-1 text-[10px] font-bold text-mc-yellow">{{ $cartItemCount }}</span>
                        @endif
                    </span>
                    <span class="hidden text-left sm:block">
                        <span class="block text-[11px] uppercase tracking-wide text-mc-muted">Your Cart</span>
                        <span class="text-sm font-bold text-mc-dark">{{ $cartItemCount ?? 0 }} item(s)</span>
                    </span>
                </a>
            </div>
        </div>
    </header>

    {{-- Dark nav with departments --}}
    <nav class="sticky top-0 z-50 bg-mc-nav text-white shadow">
        <div class="mx-auto flex max-w-store items-stretch px-4">
            <div class="relative hidden md:block" @mouseenter="departmentsOpen = true" @mouseleave="departmentsOpen = false">
                <button type="button" class="flex h-12 items-center gap-2 bg-mc-yellow px-5 font-display text-sm font-semibold uppercase tracking-wide text-mc-dark">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5h14v2H3V5zm0 4h14v2H3V9zm0 4h14v2H3v-2z"/></svg>
                    All Departments
                </button>
                <div x-show="departmentsOpen" x-cloak
                     class="absolute left-0 top-full z-50 w-64 border border-mc-border bg-white py-2 text-mc-dark shadow-xl animate-fade-in">
                    @foreach (($navCategories ?? collect()) as $category)
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                           class="flex items-center justify-between px-4 py-2.5 text-sm hover:bg-mc-yellow">
                            <span>{{ $category->name }}</span>
                            <span class="text-xs text-mc-muted">{{ $category->products_count ?? '' }}</span>
                        </a>
                    @endforeach
                    <a href="{{ route('shop.index') }}" class="block border-t border-mc-border px-4 py-2.5 text-sm font-semibold text-mc-dark hover:bg-mc-soft">
                        View All Products
                    </a>
                </div>
            </div>

            <div class="hidden flex-1 items-center gap-1 md:flex">
                <a href="{{ route('home') }}" class="px-4 py-3 text-sm font-semibold uppercase tracking-wide hover:text-mc-yellow {{ request()->routeIs('home') ? 'text-mc-yellow' : '' }}">Home</a>
                <a href="{{ route('shop.index') }}" class="px-4 py-3 text-sm font-semibold uppercase tracking-wide hover:text-mc-yellow {{ request()->routeIs('shop.*') ? 'text-mc-yellow' : '' }}">Shop</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="px-4 py-3 text-sm font-semibold uppercase tracking-wide hover:text-mc-yellow">Orders</a>
                @endauth
                <a href="{{ route('cart.index') }}" class="px-4 py-3 text-sm font-semibold uppercase tracking-wide hover:text-mc-yellow">Cart</a>
                <a href="{{ route('mobile') }}" class="px-4 py-3 text-sm font-semibold uppercase tracking-wide hover:text-mc-yellow {{ request()->routeIs('mobile') ? 'text-mc-yellow' : '' }}">Get App</a>
            </div>

            <button type="button" class="ml-auto flex items-center gap-2 py-3 text-sm font-semibold uppercase md:hidden" @click="mobileNav = !mobileNav">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5h14v2H3V5zm0 4h14v2H3V9zm0 4h14v2H3v-2z"/></svg>
                Menu
            </button>
        </div>

        <div x-show="mobileNav" x-cloak class="border-t border-white/10 bg-mc-darker px-4 py-3 md:hidden">
            <a href="{{ route('home') }}" class="block py-2 text-sm uppercase hover:text-mc-yellow">Home</a>
            <a href="{{ route('shop.index') }}" class="block py-2 text-sm uppercase hover:text-mc-yellow">Shop</a>
            <a href="{{ route('cart.index') }}" class="block py-2 text-sm uppercase hover:text-mc-yellow">Cart</a>
            <a href="{{ route('mobile') }}" class="block py-2 text-sm uppercase text-mc-yellow hover:text-white">Get App</a>
            @foreach (($navCategories ?? collect()) as $category)
                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="block py-2 text-sm text-white/80 hover:text-mc-yellow">{{ $category->name }}</a>
            @endforeach
        </div>
    </nav>

    {{-- Mobile install / Add to Home Screen hint --}}
    <div x-show="showInstall" x-cloak
         class="sticky top-12 z-40 border-b border-mc-yellow/40 bg-mc-darker px-4 py-3 text-white md:hidden"
         style="padding-left: max(1rem, env(safe-area-inset-left)); padding-right: max(1rem, env(safe-area-inset-right));">
        <div class="mx-auto flex max-w-store items-start gap-3">
            <img src="{{ asset('icons/icon-192.png') }}" alt="" class="mt-0.5 h-10 w-10 rounded-lg border border-white/10 shrink-0">
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-mc-yellow">Install App</p>
                <p class="mt-0.5 text-xs text-white/70 leading-relaxed">
                    Home screen pe add karo — app jaisa experience.
                    Android: browser menu → <strong>Install app</strong> / <strong>Add to Home screen</strong>.
                    iPhone: Share → <strong>Add to Home Screen</strong>.
                </p>
                <a href="{{ route('mobile') }}" class="mt-2 inline-block text-xs font-semibold uppercase tracking-wide text-mc-yellow underline">QR / Get App →</a>
            </div>
            <button type="button"
                    class="shrink-0 rounded px-2 py-1 text-xs text-white/60 hover:bg-white/10 hover:text-white"
                    @click="showInstall = false; try { localStorage.setItem('ee_install_dismissed', '1'); } catch (e) {}"
                    aria-label="Dismiss">✕</button>
        </div>
    </div>

    <main class="min-h-screen bg-mc-soft">
        <div class="mx-auto max-w-store px-4 py-6 sm:py-8">
            <x-flash-messages />
            {{ $slot }}
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-mc-darker text-white/70">
        <div class="mx-auto grid max-w-store gap-8 px-4 py-12 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2 lg:col-span-1">
                <p class="font-display text-2xl font-bold uppercase text-white">
                    Ehsan <span class="text-mc-yellow">Electronics</span>
                </p>
                <p class="mt-3 text-sm leading-relaxed">
                    Pakistan ka electronics store — mobiles, laptops, audio aur accessories. COD aur EasyPaisa.
                </p>
            </div>
            <div>
                <p class="mb-3 font-display text-sm font-semibold uppercase tracking-wide text-white">Find it Fast</p>
                @foreach (($navCategories ?? collect())->take(6) as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="mb-2 block text-sm hover:text-mc-yellow">{{ $category->name }}</a>
                @endforeach
            </div>
            <div>
                <p class="mb-3 font-display text-sm font-semibold uppercase tracking-wide text-white">Customer Care</p>
                <a href="{{ route('shop.index') }}" class="mb-2 block text-sm hover:text-mc-yellow">Shop</a>
                <a href="{{ route('cart.index') }}" class="mb-2 block text-sm hover:text-mc-yellow">Cart</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="mb-2 block text-sm hover:text-mc-yellow">My Orders</a>
                    <a href="{{ route('notifications.index') }}" class="mb-2 block text-sm hover:text-mc-yellow">Messages</a>
                @else
                    <a href="{{ route('login') }}" class="mb-2 block text-sm hover:text-mc-yellow">Login</a>
                    <a href="{{ route('register') }}" class="mb-2 block text-sm hover:text-mc-yellow">Register</a>
                @endauth
            </div>
            <div>
                <p class="mb-3 font-display text-sm font-semibold uppercase tracking-wide text-white">Scan to open app</p>
                @php
                    $appQrUrl = rtrim(config('app.url') ?: url('/'), '/');
                    if (str_contains($appQrUrl, 'localhost') || str_contains($appQrUrl, '127.0.0.1')) {
                        $appQrUrl = rtrim(request()->getSchemeAndHttpHost(), '/');
                    }
                @endphp
                <a href="{{ route('mobile') }}" class="inline-block rounded-lg bg-white p-2 hover:ring-2 hover:ring-mc-yellow" title="Open Get App page">
                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode($appQrUrl) }}"
                        alt="QR code — scan to open Ehsan Electronics"
                        width="140"
                        height="140"
                        class="block"
                        loading="lazy"
                    >
                </a>
                <p class="mt-2 text-xs leading-relaxed text-white/60">
                    Phone camera se scan karo → store khulega.<br>
                    Phir <strong class="text-mc-yellow">Install App</strong> / Add to Home Screen.
                </p>
                <a href="{{ route('mobile') }}" class="mt-2 inline-block text-sm text-mc-yellow hover:underline">Install tips →</a>
            </div>
        </div>
        <div class="border-t border-white/10 py-4 text-center text-xs text-white/40">
            &copy; {{ date('Y') }} Ehsan Electronics. All rights reserved.
        </div>
    </footer>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('{{ asset('sw.js') }}').catch(function () {});
            });
        }
    </script>
</body>
</html>
