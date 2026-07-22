<x-layouts.store title="Order Confirmed - Ehsan Electronics">
    <div class="max-w-2xl mx-auto text-center py-12">
        <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="font-display text-3xl font-bold text-stone-900 mb-2">Order Placed Successfully!</h1>
        <p class="text-stone-500 mb-2">Shukriya! Aapka order #{{ $order->id }} receive ho gaya hai.</p>
        <p class="text-sm text-teal-700 mb-6">Confirmation email bhej di gayi hai: <strong>{{ auth()->user()->email }}</strong></p>

        @if (in_array($order->payment_method, ['bank_transfer', 'easypaisa'], true))
            <div class="mb-8">
                @include('partials.payment-instructions', [
                    'method' => $order->payment_method,
                    'amount' => $order->total_price,
                    'orderId' => $order->id,
                ])
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-stone-200 p-6 text-left mb-8 shadow-sm">
            <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                <div>
                    <p class="text-stone-500">Order ID</p>
                    <p class="font-semibold">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-stone-500">Status</p>
                    <p class="font-semibold capitalize">{{ $order->status->value }}</p>
                </div>
                <div>
                    <p class="text-stone-500">Payment</p>
                    <p class="font-semibold">{{ payment_method_label($order->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-stone-500">Total</p>
                    <p class="font-semibold text-teal-800">{{ money($order->total_price) }}</p>
                </div>
            </div>
            <h3 class="font-semibold mb-3">Items</h3>
            @foreach ($order->items as $item)
                <div class="flex justify-between py-2 border-t border-stone-100 text-sm">
                    <span>{{ $item->product->title }} x{{ $item->quantity }}</span>
                    <span class="font-medium">{{ money($item->subtotal()) }}</span>
                </div>
            @endforeach
        </div>

        <div class="flex gap-4 justify-center">
            <a href="{{ route('orders.show', $order) }}" class="btn-primary">View Order</a>
            <a href="{{ route('shop.index') }}" class="btn-outline">Continue Shopping</a>
        </div>
    </div>
</x-layouts.store>
