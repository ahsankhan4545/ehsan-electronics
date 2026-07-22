<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use App\Repositories\Contracts\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function getOrCreateCart(?User $user, string $sessionId): Cart
    {
        if ($user) {
            return Cart::firstOrCreate(['user_id' => $user->id]);
        }

        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function findByUser(User $user): ?Cart
    {
        return Cart::where('user_id', $user->id)->first();
    }

    public function mergeSessionCartToUser(Cart $sessionCart, User $user): Cart
    {
        $userCart = Cart::firstOrCreate(['user_id' => $user->id]);

        foreach ($sessionCart->items as $sessionItem) {
            $existingItem = CartItem::where('cart_id', $userCart->id)
                ->where('product_id', $sessionItem->product_id)
                ->first();

            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $sessionItem->quantity,
                ]);
            } else {
                CartItem::create([
                    'cart_id' => $userCart->id,
                    'product_id' => $sessionItem->product_id,
                    'quantity' => $sessionItem->quantity,
                ]);
            }
        }

        $sessionCart->items()->delete();
        $sessionCart->delete();

        return $userCart->load('items.product');
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }
}
