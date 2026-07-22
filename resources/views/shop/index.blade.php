<x-layouts.store title="Shop - Ehsan Electronics">
    <div class="mb-6 border border-mc-border bg-white px-5 py-4">
        <nav class="mb-2 text-xs text-mc-muted">
            <a href="{{ route('home') }}" class="hover:text-mc-dark">Home</a>
            <span class="mx-2">/</span>
            <span class="text-mc-dark">
                @if ($activeCategory)
                    {{ $categories->firstWhere('slug', $activeCategory)?->name ?? 'Products' }}
                @else
                    Shop
                @endif
            </span>
        </nav>
        <h1 class="font-display text-2xl font-semibold uppercase tracking-wide text-mc-dark md:text-3xl">
            @if ($activeCategory)
                {{ $categories->firstWhere('slug', $activeCategory)?->name ?? 'Products' }}
            @else
                All Products
            @endif
        </h1>
    </div>

    <div class="flex flex-col gap-6 lg:flex-row">
        <aside class="lg:w-64 flex-shrink-0">
            <div class="border border-mc-border bg-white">
                <div class="bg-mc-yellow px-4 py-3 font-display text-sm font-semibold uppercase tracking-wide text-mc-dark">
                    Categories
                </div>
                <ul>
                    <li class="border-b border-mc-border">
                        <a href="{{ route('shop.index') }}"
                           class="block px-4 py-3 text-sm {{ ! $activeCategory ? 'bg-mc-soft font-semibold text-mc-dark' : 'text-mc-muted hover:bg-mc-yellow/30 hover:text-mc-dark' }}">
                            All Products
                        </a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="border-b border-mc-border last:border-0">
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                               class="flex items-center justify-between px-4 py-3 text-sm {{ $activeCategory === $category->slug ? 'bg-mc-soft font-semibold text-mc-dark' : 'text-mc-muted hover:bg-mc-yellow/30 hover:text-mc-dark' }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs">({{ $category->products_count }})</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <div class="flex-1">
            <form action="{{ route('shop.index') }}" method="GET" class="mb-4 flex overflow-hidden border-2 border-mc-yellow bg-white">
                @if ($activeCategory)
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif
                <input type="text" name="search" value="{{ $search }}" placeholder="Search products..."
                       class="min-w-0 flex-1 border-0 px-4 text-sm focus:ring-0">
                <button type="submit" class="bg-mc-yellow px-5 text-sm font-bold uppercase tracking-wide text-mc-dark hover:bg-mc-yellow-dark">Search</button>
            </form>

            <div class="grid grid-cols-1 gap-px border border-mc-border bg-mc-border sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
                    <div class="bg-white p-4">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <p class="col-span-full bg-white py-16 text-center text-mc-muted">No products found.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-layouts.store>
