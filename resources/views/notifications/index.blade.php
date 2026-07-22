<x-layouts.store title="Messages - Ehsan Electronics">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="section-title">My Messages</h1>
            <p class="mt-1 text-sm text-stone-500">Order confirmations aur account updates yahan milenge</p>
        </div>
        @if (auth()->user()->unreadNotifications->count())
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit" class="btn-outline !py-2 text-sm">Mark all as read</button>
            </form>
        @endif
    </div>

    <div class="space-y-3">
        @forelse ($notifications as $notification)
            <div class="rounded-2xl border p-5 shadow-sm transition {{ $notification->read_at ? 'border-stone-200 bg-white' : 'border-teal-200 bg-teal-50' }}">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="mb-1 flex items-center gap-2">
                            <h3 class="font-semibold text-stone-900">{{ $notification->data['title'] ?? 'Notification' }}</h3>
                            @unless ($notification->read_at)
                                <span class="rounded-full bg-amber-400 px-2 py-0.5 text-[10px] font-bold uppercase text-stone-900">New</span>
                            @endunless
                        </div>
                        <p class="text-sm text-stone-600">{{ $notification->data['message'] ?? '' }}</p>
                        <p class="mt-2 text-xs text-stone-400">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                        @csrf
                        <button type="submit" class="btn-primary !py-2 text-xs">
                            {{ isset($notification->data['order_id']) ? 'View Order' : 'Open' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-stone-300 bg-white py-16 text-center">
                <p class="text-stone-500">Abhi koi message nahi hai.</p>
                <a href="{{ route('shop.index') }}" class="btn-primary mt-4 inline-flex">Start Shopping</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $notifications->links() }}
    </div>
</x-layouts.store>
