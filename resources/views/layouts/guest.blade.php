<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ehsan Electronics') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|outfit:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-stone-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-teal-900 via-teal-800 to-stone-900">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="font-display text-3xl font-bold text-white">
                Ehsan <span class="text-amber-400">Electronics</span>
            </a>
            <p class="mt-2 text-sm text-teal-200">Pakistan's trusted electronics store</p>
        </div>

        <div class="w-full sm:max-w-md mt-2 px-6 py-6 bg-white shadow-xl overflow-hidden sm:rounded-2xl">
            {{ $slot }}
        </div>

        <a href="{{ route('home') }}" class="mt-6 text-sm text-teal-200 hover:text-amber-300 transition">← Back to store</a>
    </div>
</body>
</html>
