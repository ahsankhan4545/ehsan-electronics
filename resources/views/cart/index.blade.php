<x-layouts.store title="Shopping Cart - Ehsan Electronics">
    <h1 class="section-title mb-8">Shopping Cart</h1>

    @if ($cart->items->isEmpty())
        <div class="rounded-3xl border border-stone-200 bg-white py-16 text-center shadow-sm">
            <p class="mb-4 text-stone-500">Your cart is empty.</p>
            <a href="{{ route('shop.index') }}" class="btn-primary">Continue Shopping</a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="space-y-4 lg:col-span-2">
                @foreach ($cart->items as $item)
                    <div class="flex items-center gap-4 rounded-2xl border border-stone-200 bg-white p-4 shadow-sm">
                        <img src="{{ $item->product->imageUrl() }}" alt="{{ $item->product->title }}" class="h-20 w-20 rounded-xl object-cover">
                        <div class="flex-1">
                            <h3 class="font-semibold text-stone-900">{{ $item->product->title }}</h3>
                            <p class="text-sm text-teal-700">{{ money($item->product->effectivePrice()) }} each</p>
                        </div>
                        <form action="{{ route('cart.update', $item) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" max="{{ $item->product->stock }}"
                                   class="w-16 rounded-lg border-stone-300 text-center text-sm" onchange="this.form.submit()">
                        </form>
                        <p class="w-28 text-right font-bold text-stone-900">{{ money($item->subtotal()) }}</p>
                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="rounded-lg p-2 text-red-500 hover:bg-red-50">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="h-fit rounded-2xl border border-teal-100 bg-white p-6 shadow-sm sticky top-24">
                <h2 class="mb-4 font-display text-xl font-bold">Order Summary</h2>
                <div class="mb-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-500">Subtotal ({{ $cart->itemCount() }} items)</span>
                        <span class="font-medium">{{ money($cart->subtotal()) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-500">Shipping (Pakistan)</span>
                        <span class="font-medium text-teal-700">Free</span>
                    </div>
                    <hr class="border-stone-200">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span class="text-teal-800">{{ money($cart->subtotal()) }}</span>
                    </div>
                </div>
                @auth
                    <a href="{{ route('checkout.index') }}" class="btn-accent w-full !py-3">Proceed to Checkout</a>
                @else
                    <a href="{{ route('login') }}" class="btn-accent w-full !py-3">Login to Checkout</a>
                    <p class="mt-3 text-center text-xs text-stone-500">
                        New here? <a href="{{ route('register') }}" class="font-semibold text-teal-700">Sign Up</a>
                    </p>
                @endauth
            </div>
        </div>
    @endif
</x-layouts.store>
