@php
    $method = $method ?? null;
    $amount = $amount ?? null;
    $orderId = $orderId ?? null;
    $bank = config('payments.bank');
    $easypaisa = config('payments.easypaisa');
@endphp

@if ($method === 'bank_transfer' && ($bank['enabled'] ?? false))
    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-stone-800 text-left">
        <p class="font-semibold text-amber-900 mb-2">Bank Transfer Details</p>
        <ul class="space-y-1">
            <li><span class="text-stone-500">Bank:</span> <strong>{{ $bank['bank_name'] }}</strong></li>
            <li><span class="text-stone-500">Account Title:</span> <strong>{{ $bank['account_title'] }}</strong></li>
            <li><span class="text-stone-500">Account No:</span> <strong>{{ $bank['account_number'] }}</strong></li>
            <li><span class="text-stone-500">IBAN:</span> <strong class="break-all">{{ $bank['iban'] }}</strong></li>
            @if ($amount)
                <li><span class="text-stone-500">Amount:</span> <strong>{{ money($amount) }}</strong></li>
            @endif
            @if ($orderId)
                <li><span class="text-stone-500">Reference:</span> <strong>Order #{{ $orderId }}</strong> (transfer note mein likhein)</li>
            @endif
        </ul>
        <p class="mt-3 text-xs text-amber-800">Payment bhejne ke baad admin confirm karega. Screenshot rakh lein.</p>
    </div>
@elseif ($method === 'easypaisa' && ($easypaisa['enabled'] ?? false))
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
