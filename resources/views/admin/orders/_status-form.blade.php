@php
    $colors = [
        'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
        'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
        'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'declined' => 'bg-red-100 text-red-800 border-red-200',
    ];
    $color = $colors[$order->status->value] ?? 'bg-gray-100 text-gray-700 border-gray-200';
@endphp

<form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-wrap items-center gap-2">
    @csrf
    @method('PATCH')
    <select name="status"
            class="rounded-lg border text-sm font-medium shadow-sm focus:border-teal-500 focus:ring-teal-500 {{ $color }}">
        @foreach (\App\Enums\OrderStatus::cases() as $status)
            <option value="{{ $status->value }}" @selected($order->status === $status)>
                {{ $status->label() }}
            </option>
        @endforeach
    </select>
    <button type="submit"
            class="rounded-lg bg-teal-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-teal-800">
        Update
    </button>
</form>
