@php
    $method = $method ?? null;
    $amount = $amount ?? null;
    $orderId = $orderId ?? null;
    $easypaisa = config('payments.easypaisa');
@endphp

@if ($method === 'easypaisa' && ($easypaisa['enabled'] ?? false))
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-stone-800 text-left">
        <p class="font-semibold text-emerald-900 mb-2">EasyPaisa Details</p>
        <ul class="space-y-1">
            <li><span class="text-stone-500">Account Title:</span> <strong>{{ $easypaisa['account_title'] }}</strong></li>
            <li><span class="text-stone-500">EasyPaisa Number:</span> <strong>{{ $easypaisa['number'] }}</strong></li>
            @if ($amount)
                <li><span class="text-stone-500">Amount:</span> <strong>{{ money($amount) }}</strong></li>
            @endif
            @if ($orderId)
                <li><span class="text-stone-500">Reference:</span> <strong>Order #{{ $orderId }}</strong></li>
            @endif
        </ul>
        <p class="mt-3 text-xs text-emerald-800">Send Money karke screenshot rakh lein. Admin payment confirm karega.</p>
    </div>
@endif
