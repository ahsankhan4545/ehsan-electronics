<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function getCart(): Cart
    {
        $cart = $this->cartRepository->getOrCreateCart(
            Auth::user(),
            session()->getId()
        );

        return $cart->load('items.product');
    }

    public function addItem(int $productId, int $quantity): array
    {
        $product = $this->productRepository->find($productId);

        if (! $product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        if (! $product->isInStock()) {
            return ['success' => false, 'message' => 'Out of stock!'];
        }

        $cart = $this->getCart();
        $existingItem = $cart->items()->where('product_id', $productId)->first();
        $newQuantity = ($existingItem?->quantity ?? 0) + $quantity;

        if ($newQuantity > $product->stock) {
            return ['success' => false, 'message' => "Only {$product->stock} items available in stock."];
        }

        if ($existingItem) {
            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return ['success' => true, 'message' => 'Product added to cart!'];
    }

    public function updateItem(int $cartItemId, int $quantity): array
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('id', $cartItemId)->first();

        if (! $item) {
            return ['success' => false, 'message' => 'Cart item not found.'];
        }

        if ($quantity <= 0) {
            return $this->removeItem($cartItemId);
        }

        if ($quantity > $item->product->stock) {
            return ['success' => false, 'message' => "Only {$item->product->stock} items available in stock."];
        }

        $item->update(['quantity' => $quantity]);

        return ['success' => true, 'message' => 'Cart updated successfully.'];
    }

    public function removeItem(int $cartItemId): array
    {
        $cart = $this->getCart();
        $item = $cart->items()->where('id', $cartItemId)->first();

        if (! $item) {
            return ['success' => false, 'message' => 'Cart item not found.'];
        }

        $item->delete();

        return ['success' => true, 'message' => 'Item removed from cart.'];
    }

    public function clear(): void
    {
        $this->cartRepository->clear($this->getCart());
    }

    public function mergeOnLogin(User $user): void
    {
        $sessionCart = $this->cartRepository->getOrCreateCart(null, session()->getId());

        if ($sessionCart->items()->exists()) {
            $this->cartRepository->mergeSessionCartToUser($sessionCart, $user);
        }
    }

    public function itemCount(): int
    {
        return $this->getCart()->itemCount();
    }
}
