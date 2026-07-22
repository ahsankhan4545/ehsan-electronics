<x-layouts.admin title="Products">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">Add Product</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Product</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Category</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Price</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Stock</th>
                    <th class="px-6 py-3 text-right font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->imageUrl() }}" class="w-10 h-10 object-cover rounded">
                                <div>
                                    <p class="font-medium">{{ $product->title }}</p>
                                    @if ($product->is_featured)<span class="text-xs text-indigo-600">Featured</span>@endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 font-medium">{{ money($product->effectivePrice()) }}</td>
                        <td class="px-6 py-4">{{ $product->stock }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $products->links() }}</div>
    </div>
</x-layouts.admin>
