<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
    ) {}

    public function paginateForAdmin(): LengthAwarePaginator
    {
        return $this->orderRepository->paginateForAdmin();
    }

    public function find(int $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    public function findForUser(User $user, int $orderId): ?Order
    {
        return $this->orderRepository->findForUser($user, $orderId);
    }

    public function forUser(User $user): Collection
    {
        return $this->orderRepository->forUser($user);
    }

    public function updateStatus(Order $order, string $status): Order
    {
        return $this->orderRepository->updateStatus($order, $status);
    }

    public function updatePaymentStatus(Order $order, string $paymentStatus): Order
    {
        return $this->orderRepository->updatePaymentStatus($order, $paymentStatus);
    }
}
