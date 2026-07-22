<x-layouts.admin title="Orders">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Orders</h1>
    <p class="text-sm text-gray-500 mb-8">Status change karne ke liye dropdown se naya status select karein aur Update dabayein.</p>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500">Order</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500">Customer</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500">Total</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500">Payment</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-teal-700 hover:underline font-medium">#{{ $order->id }}</a>
                            </td>
                            <td class="px-6 py-4">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 font-medium">{{ money($order->total_price) }}</td>
                            <td class="px-6 py-4 uppercase text-gray-500">{{ $order->payment_method }}</td>
                            <td class="px-6 py-4">
                                @include('admin.orders._status-form', ['order' => $order])
                            </td>
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">{{ $orders->links() }}</div>
    </div>
</x-layouts.admin>
