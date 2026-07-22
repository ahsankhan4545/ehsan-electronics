<x-layouts.admin title="Create Category">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Create Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white rounded-xl border border-gray-100 p-6 max-w-lg">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Slug (optional)</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg">Create</button>
            <a href="{{ route('admin.categories.index') }}" class="border border-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
