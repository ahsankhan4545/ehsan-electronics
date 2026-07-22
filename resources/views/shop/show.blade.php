<x-layouts.store :title="$product->title . ' - Ehsan Electronics'">
    <nav class="mb-4 text-xs text-mc-muted">
        <a href="{{ route('home') }}" class="hover:text-mc-dark">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-mc-dark">Shop</a>
        <span class="mx-2">/</span>
        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-mc-dark">{{ $product->category->name }}</a>
        <span class="mx-2">/</span>
        <span class="text-mc-dark">{{ $product->title }}</span>
    </nav>

    <div class="grid grid-cols-1 gap-8 border border-mc-border bg-white p-4 md:p-6 lg:grid-cols-2">
        <div class="overflow-hidden bg-mc-soft">
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->title }}" class="aspect-square w-full object-cover">
        </div>

        <div class="flex flex-col justify-center">
            <p class="mb-2 text-xs font-bold uppercase tracking-wider text-mc-muted">{{ $product->category->name }}</p>
            <h1 class="font-display mb-4 text-3xl font-semibold uppercase tracking-wide text-mc-dark md:text-4xl">{{ $product->title }}</h1>

            <div class="mb-5 flex flex-wrap items-center gap-3">
                <span class="text-3xl font-bold text-mc-price">{{ money($product->effectivePrice()) }}</span>
                @if ($product->isOnSale())
                    <span class="text-lg text-mc-muted line-through">{{ money($product->price) }}</span>
                    <span class="bg-mc-yellow px-2 py-1 text-xs font-bold uppercase text-mc-dark">
                        Save {{ round((1 - $product->sale_price / $product->price) * 100) }}%
                    </span>
                @endif
            </div>

            <div class="mb-6">
                @if ($product->isInStock())
                    <span class="inline-flex items-center gap-2 bg-green-50 px-3 py-1.5 text-sm font-medium text-green-800">
                        <span class="h-2 w-2 rounded-full bg-green-500"></span>
                        In Stock — {{ $product->stock }} available
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700">
                        <span class="h-2 w-2 rounded-full bg-red-500"></span>
                        Out of Stock
                    </span>
                @endif
            </div>

            <p class="mb-8 text-base leading-relaxed text-mc-muted">{{ $product->description }}</p>

            @if ($product->isInStock())
                <div class="space-y-3" x-data="{ qty: 1 }">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold uppercase tracking-wide text-mc-dark">Qty</span>
                        <div class="flex items-center overflow-hidden border border-mc-border bg-white">
                            <button type="button" @click="qty = Math.max(1, qty - 1)" class="px-4 py-2 text-lg text-mc-muted hover:bg-mc-soft">−</button>
                            <span class="min-w-[3rem] text-center text-sm font-semibold" x-text="qty"></span>
                            <button type="button" @click="qty = Math.min({{ $product->stock }}, qty + 1)" class="px-4 py-2 text-lg text-mc-muted hover:bg-mc-soft">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" :value="qty">
                            <button type="submit" class="btn-outline w-full !py-3">Add to Cart</button>
                        </form>
                        <form action="{{ route('cart.buy-now') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" :value="qty">
                            <button type="submit" class="btn-accent w-full !py-3 !text-base">Buy Now</button>
                        </form>
                    </div>
                </div>
            @else
                <button disabled class="w-full cursor-not-allowed bg-mc-border py-3 font-semibold uppercase text-mc-muted">Currently Unavailable</button>
            @endif
        </div>
    </div>
</x-layouts.store>
