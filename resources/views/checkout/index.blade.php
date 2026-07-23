<x-layouts.store title="Checkout - Ehsan Electronics">
    <h1 class="section-title mb-8">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST"
          class="grid grid-cols-1 lg:grid-cols-3 gap-8"
          x-data="{ sameShipping: true, paymentMethod: '{{ old('payment_method', 'cod') }}' }">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
                <h2 class="font-display text-lg font-bold mb-4">Delivery Details (Pakistan)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-stone-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                               class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                               class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Mobile Number</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required placeholder="-----"
                               class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-stone-700 mb-1">Complete Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" required placeholder="House #, Street, Area"
                               class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">City</label>
                        <input type="text" name="city" value="{{ old('city', auth()->user()->city) }}" required placeholder="Lahore"
                               class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Province / State</label>
                        <input type="text" name="state" value="{{ old('state') }}" required placeholder="Punjab"
                               class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Postal Code</label>
                        <input type="text" name="zip" value="{{ old('zip') }}" required placeholder="54000"
                               class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Country</label>
                        <input type="text" name="country" value="{{ old('country', 'Pakistan') }}" required
                               class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
                <label class="flex items-center gap-2 mb-4">
                    <input type="checkbox" name="shipping_same_as_billing" value="1" x-model="sameShipping" checked
                           class="rounded border-stone-300 text-teal-700 focus:ring-teal-600">
                    <span class="text-sm font-medium text-stone-700">Shipping address same as above</span>
                </label>
                <div x-show="!sameShipping" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-stone-700 mb-1">Shipping Name</label>
                        <input type="text" name="shipping_name" value="{{ old('shipping_name') }}" class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-stone-700 mb-1">Shipping Address</label>
                        <input type="text" name="shipping_address" value="{{ old('shipping_address') }}" class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">City</label>
                        <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Province</label>
                        <input type="text" name="shipping_state" value="{{ old('shipping_state') }}" class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Postal Code</label>
                        <input type="text" name="shipping_zip" value="{{ old('shipping_zip') }}" class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Country</label>
                        <input type="text" name="shipping_country" value="{{ old('shipping_country', 'Pakistan') }}" class="w-full rounded-xl border-stone-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
                <h2 class="font-display text-lg font-bold mb-4">Payment Method</h2>
                <div class="space-y-3">
                    <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer"
                           :class="paymentMethod === 'cod' ? 'border-teal-600 bg-teal-50' : 'border-stone-200 hover:border-teal-400'">
                        <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="mt-1 text-teal-700 focus:ring-teal-600">
                        <div>
                            <span class="font-semibold text-stone-900">Cash on Delivery (COD)</span>
                            <p class="text-sm text-stone-500">Order milne par cash mein pay karein</p>
                        </div>
                    </label>

                    @if (config('payments.easypaisa.enabled'))
                        <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer"
                               :class="paymentMethod === 'easypaisa' ? 'border-teal-600 bg-teal-50' : 'border-stone-200 hover:border-teal-400'">
                            <input type="radio" name="payment_method" value="easypaisa" x-model="paymentMethod" class="mt-1 text-teal-700 focus:ring-teal-600">
                            <div class="flex-1">
                                <span class="font-semibold text-stone-900">EasyPaisa</span>
                                <p class="text-sm text-stone-500">EasyPaisa number pe Send Money</p>
                            </div>
                        </label>
                        <div x-show="paymentMethod === 'easypaisa'" x-cloak>
                            @include('partials.payment-instructions', [
                                'method' => 'easypaisa',
                                'amount' => $cart->subtotal(),
                            ])
                        </div>
                    @endif
                </div>
                @error('payment_method')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-stone-200 p-6 h-fit sticky top-24 shadow-sm">
            <h2 class="font-display text-lg font-bold mb-4">Order Summary</h2>
            <div class="space-y-3 mb-6">
                @foreach ($cart->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-600">{{ $item->product->title }} x{{ $item->quantity }}</span>
                        <span class="font-medium">{{ money($item->subtotal()) }}</span>
                    </div>
                @endforeach
                <hr>
                <div class="flex justify-between text-lg font-bold">
                    <span>Total</span>
                    <span class="text-teal-800">{{ money($cart->subtotal()) }}</span>
                </div>
            </div>
            <button type="submit" class="btn-accent w-full !py-3">Place Order</button>
        </div>
    </form>
</x-layouts.store>
