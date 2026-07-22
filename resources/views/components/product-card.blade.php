@props(['product'])

<div class="group flex h-full flex-col bg-white transition">
    <a href="{{ route('shop.show', $product->slug) }}" class="block">
        <div class="relative mb-3 aspect-square overflow-hidden bg-mc-soft">
            <img
                src="{{ $product->imageUrl() }}"
                alt="{{ $product->title }}"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                loading="lazy"
            >
            @if ($product->isOnSale())
                <span class="absolute left-0 top-3 bg-mc-price px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-white">Sale</span>
            @endif
            @if (! $product->isInStock())
                <span class="absolute inset-0 flex items-center justify-center bg-mc-dark/60 text-xs font-bold uppercase tracking-wide text-white">Out of Stock</span>
            @endif
        </div>
    </a>

    <div class="flex flex-1 flex-col">
        <p class="mb-1 text-[11px] font-semibold uppercase tracking-wider text-mc-muted">{{ $product->category->name }}</p>
        <a href="{{ route('shop.show', $product->slug) }}">
            <h3 class="mb-2 line-clamp-2 min-h-[2.5rem] text-sm font-semibold text-mc-dark transition group-hover:text-mc-price">{{ $product->title }}</h3>
        </a>
        <div class="mb-3 flex items-baseline gap-2">
            <span class="text-lg font-bold text-mc-price">{{ money($product->effectivePrice()) }}</span>
            @if ($product->isOnSale())
                <span class="text-sm text-mc-muted line-through">{{ money($product->price) }}</span>
            @endif
        </div>

        @if ($product->isInStock())
            <div class="mt-auto grid grid-cols-2 gap-2">
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-mc-yellow px-2 py-2 text-[11px] font-bold uppercase tracking-wide text-mc-dark hover:bg-mc-yellow-dark">
                        Add to Cart
                    </button>
                </form>
                <form action="{{ route('cart.buy-now') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-mc-dark px-2 py-2 text-[11px] font-bold uppercase tracking-wide text-white hover:bg-black">
                        Buy Now
                    </button>
                </form>
            </div>
        @else
            <button disabled class="mt-auto w-full cursor-not-allowed bg-mc-border py-2 text-[11px] font-bold uppercase text-mc-muted">Unavailable</button>
        @endif
    </div>
</div>
