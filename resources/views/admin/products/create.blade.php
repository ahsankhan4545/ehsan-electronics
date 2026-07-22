<x-layouts.admin title="Create Product">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Create Product</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-gray-100 p-6 max-w-2xl">
        @csrf
        @include('admin.products._form')
        <div class="flex gap-3 mt-6">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg">Create Product</button>
            <a href="{{ route('admin.products.index') }}" class="border border-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
