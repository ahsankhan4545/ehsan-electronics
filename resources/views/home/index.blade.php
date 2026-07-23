<x-layouts.store title="Ehsan Electronics - Pakistan">

    {{-- MediaCenter-style hero: departments + banner --}}
    <section class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-12 animate-fade-in">
        <aside class="hidden lg:col-span-3 lg:block">
            <div class="overflow-hidden border border-mc-border bg-white shadow-sm">
                <div class="bg-mc-yellow px-4 py-3 font-display text-sm font-semibold uppercase tracking-wide text-mc-dark">
                    Shop by Department
                </div>
                <ul>
                    @foreach ($categories as $category)
                        <li class="border-b border-mc-border last:border-0">
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                               class="flex items-center justify-between px-4 py-3 text-sm text-mc-dark transition hover:bg-mc-yellow/40">
                                <span class="font-medium">{{ $category->name }}</span>
                                <span class="text-xs text-mc-muted">{{ $category->products_count }}</span>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('shop.index') }}" class="block bg-mc-soft px-4 py-3 text-sm font-semibold uppercase tracking-wide text-mc-dark hover:bg-mc-yellow">
                            All Products →
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="relative min-h-[320px] overflow-hidden bg-mc-dark lg:col-span-9 lg:min-h-[380px]" x-data="{ slide: 0 }" x-init="setInterval(() => { slide = slide === 1 ? 0 : slide + 1 }, 5000)">
            <div class="absolute inset-0 transition-opacity duration-700" :class="slide === 0 ? 'opacity-100' : 'opacity-0'">
                <img src="https://images.unsplash.com/photo-1498049794561-7780e7231661?w=1400&h=700&fit=crop" alt="Laptops" class="h-full w-full object-cover opacity-50">
                <div class="absolute inset-0 bg-gradient-to-r from-mc-darker via-mc-dark/80 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-14">
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.25em] text-mc-yellow animate-slide-soft">New Arrivals</p>
                    <h1 class="font-display max-w-lg text-4xl font-bold uppercase leading-none text-white md:text-5xl">
                        Ehsan Electronics
                    </h1>
                    <p class="mt-4 max-w-md text-sm text-white/80 md:text-base">
                        Latest mobiles, laptops aur gadgets — PKR pricing, COD & EasyPaisa.
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn-accent mt-6 w-fit">Shop Now</a>
                </div>
            </div>
            <div class="absolute inset-0 transition-opacity duration-700" :class="slide === 1 ? 'opacity-100' : 'opacity-0'">
                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=1400&h=700&fit=crop" alt="Mobiles" class="h-full w-full object-cover opacity-50">
                <div class="absolute inset-0 bg-gradient-to-r from-mc-darker via-mc-dark/80 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-14">
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.25em] text-mc-yellow">Best Deals</p>
                    <h2 class="font-display max-w-lg text-4xl font-bold uppercase leading-none text-white md:text-5xl">
                        Mobile Phones
                    </h2>
                    <p class="mt-4 max-w-md text-sm text-white/80 md:text-base">
                        Top smartphones Pakistan ke liye — fast delivery aur cash on delivery.
                    </p>
                    <a href="{{ route('shop.index', ['category' => 'mobile-phones']) }}" class="btn-accent mt-6 w-fit">Browse Mobiles</a>
                </div>
            </div>
            <div class="absolute bottom-4 left-8 flex gap-2 md:left-14">
                <button type="button" @click="slide = 0" class="h-2.5 w-2.5 rounded-full" :class="slide === 0 ? 'bg-mc-yellow' : 'bg-white/40'"></button>
                <button type="button" @click="slide = 1" class="h-2.5 w-2.5 rounded-full" :class="slide === 1 ? 'bg-mc-yellow' : 'bg-white/40'"></button>
            </div>
        </div>
    </section>

    {{-- Service icons strip --}}
    <section class="mb-8 grid grid-cols-2 border border-mc-border bg-white md:grid-cols-4 animate-fade-up">
        <div class="flex items-center gap-3 border-b border-mc-border px-4 py-5 md:border-b-0 md:border-r">
            <div class="flex h-10 w-10 items-center justify-center bg-mc-yellow text-mc-dark">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-mc-dark">Free Support</p>
                <p class="text-[11px] text-mc-muted">Order help anytime</p>
            </div>
        </div>
        <div class="flex items-center gap-3 border-b border-l border-mc-border px-4 py-5 md:border-b-0 md:border-l-0 md:border-r">
            <div class="flex h-10 w-10 items-center justify-center bg-mc-yellow text-mc-dark">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 10v-1"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-mc-dark">Best Prices</p>
                <p class="text-[11px] text-mc-muted">PKR fair pricing</p>
            </div>
        </div>
        <div class="flex items-center gap-3 border-mc-border px-4 py-5 md:border-r">
            <div class="flex h-10 w-10 items-center justify-center bg-mc-yellow text-mc-dark">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-mc-dark">Easy Payment</p>
                <p class="text-[11px] text-mc-muted">COD · EasyPaisa</p>
            </div>
        </div>
        <div class="flex items-center gap-3 border-l border-mc-border px-4 py-5 md:border-l-0">
            <div class="flex h-10 w-10 items-center justify-center bg-mc-yellow text-mc-dark">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-mc-dark">Quality Products</p>
                <p class="text-[11px] text-mc-muted">Trusted electronics</p>
            </div>
        </div>
    </section>

    {{-- Category banners --}}
    <section class="mb-8 grid grid-cols-2 gap-4 md:grid-cols-4">
        @php
            $categoryImages = [
                'mobile-phones' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&h=400&fit=crop',
                'laptops' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=600&h=400&fit=crop',
                'audio' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=400&fit=crop',
                'accessories' => 'https://images.unsplash.com/photo-1625948515291-69613efd103f?w=600&h=400&fit=crop',
            ];
        @endphp
        @foreach ($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
               class="group relative block overflow-hidden border border-mc-border bg-white">
                <img src="{{ $categoryImages[$category->slug] ?? 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&h=400&fit=crop' }}"
                     alt="{{ $category->name }}"
                     class="h-36 w-full object-cover transition duration-500 group-hover:scale-105 md:h-40">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3">
                    <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white md:text-base">{{ $category->name }}</h3>
                    <p class="text-[11px] text-mc-yellow">{{ $category->products_count }} products</p>
                </div>
            </a>
        @endforeach
    </section>

    {{-- Featured products --}}
    <section class="border border-mc-border bg-white">
        <div class="flex items-center justify-between border-b border-mc-border px-4 py-3">
            <h2 class="font-display text-lg font-semibold uppercase tracking-wide text-mc-dark">
                <span class="border-b-2 border-mc-yellow pb-3">Featured Products</span>
            </h2>
            <a href="{{ route('shop.index') }}" class="text-xs font-bold uppercase tracking-wide text-mc-muted hover:text-mc-dark">View all</a>
        </div>
        <div class="grid grid-cols-1 gap-px bg-mc-border sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($featuredProducts as $product)
                <div class="bg-white p-4">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <p class="col-span-full bg-white py-16 text-center text-mc-muted">No featured products yet.</p>
            @endforelse
        </div>
    </section>
</x-layouts.store>
