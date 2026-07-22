<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator
    {
        return Order::with(['user', 'items.product'])
            ->latest()
            ->paginate($perPage);
    }

    public function findForUser(User $user, int $orderId): ?Order
    {
        return Order::with('items.product')
            ->where('user_id', $user->id)
            ->where('id', $orderId)
            ->first();
    }

    public function find(int $id): ?Order
    {
        return Order::with(['user', 'items.product'])->find($id);
    }

    public function create(array $data, array $items): Order
    {
        return DB::transaction(function () use ($data, $items) {
            $order = Order::create($data);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            return $order->load('items.product');
        });
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);

        return $order->fresh(['user', 'items.product']);
    }

    public function updatePaymentStatus(Order $order, string $paymentStatus): Order
    {
        $order->update(['payment_status' => $paymentStatus]);

        return $order->fresh(['user', 'items.product']);
    }

    public function forUser(User $user): Collection
    {
        return Order::with('items.product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }
}
