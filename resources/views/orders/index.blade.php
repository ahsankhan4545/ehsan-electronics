<x-layouts.store title="My Orders - Ehsan Electronics">
    <h1 class="section-title mb-8">My Orders</h1>

    @if ($orders->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl border border-stone-200">
            <p class="text-stone-500 mb-4">You haven't placed any orders yet.</p>
            <a href="{{ route('shop.index') }}" class="btn-primary">Start Shopping</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($orders as $order)
                <div class="bg-white rounded-2xl border border-stone-200 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-sm">
                    <div>
                        <p class="font-semibold text-stone-900">Order #{{ $order->id }}</p>
                        <p class="text-sm text-stone-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        <p class="text-sm text-stone-500">{{ $order->items->count() }} item(s)</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize
                            @if($order->status->value === 'completed') bg-green-100 text-green-700
                            @elseif($order->status->value === 'declined') bg-red-100 text-red-700
                            @elseif($order->status->value === 'processing') bg-blue-100 text-blue-700
                            @else bg-amber-100 text-amber-800 @endif">
                            {{ $order->status->value }}
                        </span>
                        <span class="font-bold text-teal-800">{{ money($order->total_price) }}</span>
                        <a href="{{ route('orders.show', $order) }}" class="text-teal-700 hover:text-teal-900 text-sm font-medium">Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.store>
