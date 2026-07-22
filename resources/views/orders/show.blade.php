<x-layouts.store title="Order #{{ $order->id }} - Ehsan Electronics">
    <nav class="text-sm text-stone-500 mb-6">
        <a href="{{ route('orders.index') }}" class="hover:text-teal-700">My Orders</a>
        <span class="mx-2">/</span>
        <span class="text-stone-900">Order #{{ $order->id }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
                <h2 class="font-display text-lg font-bold mb-4">Order Items</h2>
                @foreach ($order->items as $item)
                    <div class="flex gap-4 py-4 border-b border-stone-100 last:border-0">
                        <img src="{{ $item->product->imageUrl() }}" class="w-16 h-16 object-cover rounded-lg">
                        <div class="flex-1">
                            <h3 class="font-medium text-stone-900">{{ $item->product->title }}</h3>
                            <p class="text-sm text-stone-500">Qty: {{ $item->quantity }} · {{ money($item->price) }} each</p>
                        </div>
                        <p class="font-semibold">{{ money($item->subtotal()) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="space-y-6">
            @if (in_array($order->payment_method, ['bank_transfer', 'easypaisa'], true) && $order->payment_status !== 'paid')
                @include('partials.payment-instructions', [
                    'method' => $order->payment_method,
                    'amount' => $order->total_price,
                    'orderId' => $order->id,
                ])
            @endif
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
                <h2 class="font-display text-lg font-bold mb-4">Order Details</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between"><dt class="text-stone-500">Status</dt><dd class="font-medium capitalize">{{ $order->status->value }}</dd></div>
                    <div class="flex justify-between"><dt class="text-stone-500">Payment</dt><dd class="font-medium">{{ payment_method_label($order->payment_method) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-stone-500">Payment Status</dt><dd class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment_status) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-stone-500">Total</dt><dd class="font-bold text-lg text-teal-800">{{ money($order->total_price) }}</dd></div>
                </dl>
            </div>
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
                <h2 class="font-display text-lg font-bold mb-4">Billing Address</h2>
                <p class="text-sm text-stone-600 whitespace-pre-line">{{ $order->billing_address }}</p>
            </div>
        </div>
    </div>
</x-layouts.store>
