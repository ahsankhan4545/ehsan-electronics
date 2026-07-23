<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-display text-2xl font-bold text-stone-900">Create Customer Account</h1>
        <p class="mt-1 text-sm text-stone-500">Sign up to shop at Ehsan Electronics</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Full Name" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="e.g. Muhammad Ali" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email Address" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="phone" value="Mobile Number (Pakistan)" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="-----" />
            <p class="mt-1 text-xs text-stone-400">Format: 03XXXXXXXXX</p>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="city" value="City" />
            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required placeholder="e.g. Lahore, Karachi, Islamabad" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn-accent w-full !py-3 mt-2">
            Sign Up
        </button>

        <p class="text-center text-sm text-stone-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-teal-700 hover:text-teal-900">Login here</a>
        </p>
    </form>
</x-guest-layout>
