<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderConfirmedNotification;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CheckoutService
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private ProductRepositoryInterface $productRepository,
        private CartService $cartService,
        private PaymentService $paymentService,
    ) {}

    public function process(Cart $cart, User $user, array $data): Order
    {
        if ($cart->items->isEmpty()) {
            throw new RuntimeException('Your cart is empty.');
        }

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                throw new RuntimeException("Insufficient stock for {$item->product->title}.");
            }
        }

        return DB::transaction(function () use ($cart, $user, $data) {
            $total = $cart->subtotal();
            $paymentMethod = $data['payment_method'] ?? 'cod';

            $paymentResult = $this->paymentService->process($paymentMethod, $total, $data);

            $order = $this->orderRepository->create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => OrderStatus::Pending,
                'billing_address' => $this->formatAddress($data, 'billing'),
                'shipping_address' => $this->formatAddress($data, 'shipping'),
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentResult['status'],
                'stripe_payment_id' => $paymentResult['payment_id'] ?? null,
            ], $cart->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->effectivePrice(),
            ])->toArray());

            foreach ($cart->items as $item) {
                $decremented = $this->productRepository->decrementStock(
                    $item->product,
                    $item->quantity
                );

                if (! $decremented) {
                    throw new RuntimeException("Failed to update stock for {$item->product->title}.");
                }
            }

            $this->cartService->clear();

            // Email + in-app notification after order is safely saved
            DB::afterCommit(function () use ($user, $order) {
                try {
                    $user->notify(new OrderConfirmedNotification($order->fresh(['items.product'])));
                } catch (\Throwable $e) {
                    report($e);
                }
            });

            return $order;
        });
    }

    private function formatAddress(array $data, string $type): string
    {
        $prefix = $type === 'billing' ? 'billing' : 'shipping';

        return implode("\n", array_filter([
            $data["{$prefix}_name"] ?? $data['name'] ?? null,
            $data["{$prefix}_address"] ?? $data['address'] ?? null,
            ($data["{$prefix}_city"] ?? $data['city'] ?? '').', '.($data["{$prefix}_state"] ?? $data['state'] ?? '').' '.($data["{$prefix}_zip"] ?? $data['zip'] ?? ''),
            $data["{$prefix}_country"] ?? $data['country'] ?? null,
            $data["{$prefix}_phone"] ?? $data['phone'] ?? null,
        ]));
    }
}
