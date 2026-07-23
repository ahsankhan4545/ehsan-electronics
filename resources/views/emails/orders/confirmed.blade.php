<x-mail::message>
# Order Confirmed — #{{ $order->id }}

Assalam o Alaikum {{ $customerName }},

Shukriya! Aapka order **Ehsan Electronics** pe successfully place ho gaya hai.

## Order Details
- **Order ID:** #{{ $order->id }}
- **Total:** {{ money($order->total_price) }}
- **Payment:** {{ payment_method_label($order->payment_method) }}
- **Status:** {{ $order->status->label() }}

## Items
@foreach ($order->items as $item)
- {{ $item->product->title }} × {{ $item->quantity }} — {{ money($item->subtotal()) }}
@endforeach

@if ($order->payment_method === 'easypaisa')
## EasyPaisa Details
- **Account Title:** {{ config('payments.easypaisa.account_title') }}
- **Number:** {{ config('payments.easypaisa.number') }}
- Amount: {{ money($order->total_price) }} — reference: **Order #{{ $order->id }}**
@endif

<x-mail::button :url="route('orders.show', $order)" color="success">
View My Order
</x-mail::button>

Agar koi sawal ho to humse contact karein.<br>
**Ehsan Electronics — Pakistan**
</x-mail::message>
