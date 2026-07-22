<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-display text-2xl font-bold text-stone-900">Customer Login</h1>
        <p class="mt-1 text-sm text-stone-500">Welcome back to Ehsan Electronics</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Email Address" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-teal-700 shadow-sm focus:ring-teal-600" name="remember">
                <span class="ms-2 text-sm text-stone-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-teal-700 hover:text-teal-900" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full !py-3">
            Login
        </button>

        <p class="text-center text-sm text-stone-600">
            New customer?
            <a href="{{ route('register') }}" class="font-semibold text-amber-600 hover:text-amber-700">Create an account (Sign Up)</a>
        </p>
        <p class="text-center text-xs text-stone-400 mt-4">
            Admin ho?
            <a href="{{ route('admin.login') }}" class="text-teal-700 hover:underline">Admin Login</a>
        </p>
    </form>
</x-guest-layout>
