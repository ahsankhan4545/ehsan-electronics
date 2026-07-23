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
        $user = Auth::user();
        $sessionId = session()->getId();

        if ($user) {
            // Safety net: merge any lingering guest cart (session payload + session_id).
            $this->mergeOnLogin($user);

            return $this->cartRepository->getOrCreateCart($user, $sessionId)
                ->load('items.product');
        }

        // Prefer cart_id stored in session payload — survives session()->regenerate()
        // (DB session_id alone does not migrate when the cookie ID changes).
        $cart = $this->resolveGuestCart($sessionId);
        session(['cart_id' => $cart->id]);

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
        session()->forget('cart_id');
    }

    /**
     * Merge guest cart into the authenticated user's cart.
     *
     * Looks up by session('cart_id') first (survives regenerate), then by session_id.
     */
    public function mergeOnLogin(User $user, ?string $previousSessionId = null): void
    {
        $sessionCart = $this->findGuestCart($previousSessionId ?? session()->getId());

        if ($sessionCart && $sessionCart->items()->exists()) {
            $this->cartRepository->mergeSessionCartToUser($sessionCart, $user);
        }

        session()->forget('cart_id');
    }

    public function itemCount(): int
    {
        return $this->getCart()->itemCount();
    }

    private function resolveGuestCart(string $sessionId): Cart
    {
        $existing = $this->findGuestCart($sessionId);

        if ($existing) {
            if ($existing->session_id !== $sessionId) {
                $existing->update(['session_id' => $sessionId]);
            }

            return $existing;
        }

        return $this->cartRepository->getOrCreateCart(null, $sessionId);
    }

    private function findGuestCart(string $sessionId): ?Cart
    {
        $cartId = session('cart_id');

        if ($cartId) {
            $byId = Cart::query()
                ->where('id', $cartId)
                ->whereNull('user_id')
                ->first();

            if ($byId) {
                return $byId;
            }
        }

        return Cart::query()
            ->where('session_id', $sessionId)
            ->whereNull('user_id')
            ->first();
    }
}
