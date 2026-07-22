<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator;

    public function findForUser(User $user, int $orderId): ?Order;

    public function find(int $id): ?Order;

    public function create(array $data, array $items): Order;

    public function updateStatus(Order $order, string $status): Order;

    public function updatePaymentStatus(Order $order, string $paymentStatus): Order;

    public function forUser(User $user): Collection;
}
