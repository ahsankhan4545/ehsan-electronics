<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
    ) {}

    public function index(): View
    {
        $cart = $this->cartService->getCart();

        return view('cart.index', compact('cart'));
    }

    public function store(AddToCartRequest $request): RedirectResponse
    {
        $result = $this->cartService->addItem(
            $request->validated('product_id'),
            $request->validated('quantity')
        );

        return back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }

    public function buyNow(AddToCartRequest $request): RedirectResponse
    {
        $result = $this->cartService->addItem(
            $request->validated('product_id'),
            $request->validated('quantity')
        );

        if (! $result['success']) {
            return back()->with('error', $result['message']);
        }

        if (! auth()->check()) {
            return redirect()->route('login')
                ->with('success', 'Product ready! Please login to complete your purchase.');
        }

        return redirect()->route('checkout.index')
            ->with('success', 'Almost there — complete your order below.');
    }

    public function update(UpdateCartItemRequest $request, int $cartItem): RedirectResponse
    {
        $result = $this->cartService->updateItem(
            $cartItem,
            $request->validated('quantity')
        );

        return back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }

    public function destroy(int $cartItem): RedirectResponse
    {
        $result = $this->cartService->removeItem($cartItem);

        return back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }
}
