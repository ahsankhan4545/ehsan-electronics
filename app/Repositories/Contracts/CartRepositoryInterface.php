<?php

namespace App\Repositories\Contracts;

use App\Models\Cart;
use App\Models\User;

interface CartRepositoryInterface
{
    public function getOrCreateCart(?User $user, string $sessionId): Cart;

    public function findByUser(User $user): ?Cart;

    public function mergeSessionCartToUser(Cart $sessionCart, User $user): Cart;

    public function clear(Cart $cart): void;
}
