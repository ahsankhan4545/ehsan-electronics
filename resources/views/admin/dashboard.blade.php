<x-layouts.admin title="Dashboard">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <p class="text-sm text-gray-500 mb-1">Total Products</p>
            <p class="text-3xl font-bold text-gray-900">{{ $productCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <p class="text-sm text-gray-500 mb-1">Categories</p>
            <p class="text-3xl font-bold text-gray-900">{{ $categoryCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <p class="text-sm text-gray-500 mb-1">Recent Orders</p>
            <p class="text-3xl font-bold text-gray-900">{{ $recentOrders->total() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold">Recent Orders</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Order</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Customer</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Total</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Status</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-4"><a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline">#{{ $order->id }}</a></td>
                        <td class="px-6 py-4">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 font-medium">{{ money($order->total_price) }}</td>
                        <td class="px-6 py-4">
                            @include('admin.orders._status-form', ['order' => $order])
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
