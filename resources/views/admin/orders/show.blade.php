<x-layouts.admin title="Order #{{ $order->id }}">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:underline text-sm">&larr; Back to Orders</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="text-lg font-semibold mb-4">Order Items</h2>
                @foreach ($order->items as $item)
                    <div class="flex gap-4 py-3 border-b border-gray-100 last:border-0">
                        <img src="{{ $item->product->imageUrl() }}" class="w-12 h-12 object-cover rounded">
                        <div class="flex-1">
                            <p class="font-medium">{{ $item->product->title }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} � {{ money($item->price) }}</p>
                        </div>
                        <p class="font-semibold">{{ money($item->subtotal()) }}</p>
                    </div>
                @endforeach
                <div class="flex justify-between pt-4 font-bold text-lg">
                    <span>Total</span>
                    <span>{{ money($order->total_price) }}</span>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="text-lg font-semibold mb-4">Addresses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Billing</h3>
                        <p class="text-sm whitespace-pre-line">{{ $order->billing_address }}</p>
                    </div>
                    @if ($order->shipping_address)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Shipping</h3>
                            <p class="text-sm whitespace-pre-line">{{ $order->shipping_address }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="text-lg font-semibold mb-4">Customer</h2>
                <p class="font-medium">{{ $order->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="text-lg font-semibold mb-2">Update Status</h2>
                <p class="text-xs text-gray-500 mb-4">Pending → Processing → Completed (ya Declined)</p>
                @include('admin.orders._status-form', ['order' => $order])
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h2 class="text-lg font-semibold mb-2">Payment</h2>
                <div class="text-sm space-y-2 mb-4">
                    <div class="flex justify-between"><span class="text-gray-500">Method</span><span class="font-medium">{{ payment_method_label($order->payment_method) }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="capitalize font-medium">{{ str_replace('_', ' ', $order->payment_status) }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Date</span><span>{{ $order->created_at->format('M d, Y h:i A') }}</span></div>
                </div>
                <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <select name="payment_status" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="awaiting_payment" @selected($order->payment_status === 'awaiting_payment')>Awaiting Payment</option>
                        <option value="pending" @selected($order->payment_status === 'pending')>Pending</option>
                        <option value="paid" @selected($order->payment_status === 'paid')>Paid</option>
                        <option value="failed" @selected($order->payment_status === 'failed')>Failed</option>
                    </select>
                    <button type="submit" class="w-full rounded-lg bg-teal-700 px-3 py-2 text-sm font-semibold text-white hover:bg-teal-800">
                        Update Payment
                    </button>
                </form>
                <p class="mt-2 text-xs text-gray-500">Bank / EasyPaisa payment milne ke baad yahan <strong>Paid</strong> select karein.</p>
            </div>
        </div>
    </div>
</x-layouts.admin>
