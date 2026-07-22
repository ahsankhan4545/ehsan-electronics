<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Ehsan Electronics</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|outfit:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen">
        <div class="hidden w-1/2 bg-teal-950 text-white lg:flex lg:flex-col lg:justify-center lg:px-16">
            <p class="font-display text-4xl font-bold">Ehsan <span class="text-amber-400">Electronics</span></p>
            <p class="mt-4 text-lg text-teal-200">Admin Control Panel</p>
            <p class="mt-2 text-sm text-teal-400">Products, categories aur orders yahan manage karein.</p>
        </div>

        <div class="flex w-full items-center justify-center bg-stone-100 px-4 lg:w-1/2">
            <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-lg">
                <div class="mb-6 text-center lg:text-left">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-600">Admin Access Only</p>
                    <h1 class="font-display mt-1 text-2xl font-bold text-stone-900">Admin Login</h1>
                    <p class="mt-1 text-sm text-stone-500">Customer accounts yahan login nahi kar sakte</p>
                </div>

                <x-flash-messages />

                <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-stone-700">Admin Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="mt-1 w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-stone-700">Password</label>
                        <input id="password" type="password" name="password" required
                               class="mt-1 w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm text-stone-600">
                        <input type="checkbox" name="remember" class="rounded border-stone-300 text-teal-700 focus:ring-teal-600">
                        Remember me
                    </label>
                    <button type="submit" class="btn-accent w-full !py-3">Login to Admin Panel</button>
                </form>

                <p class="mt-6 text-center text-sm text-stone-500">
                    Customer ho?
                    <a href="{{ route('login') }}" class="font-semibold text-teal-700 hover:underline">Customer Login</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
