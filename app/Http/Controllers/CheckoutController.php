<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RuntimeException;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private CheckoutService $checkoutService,
    ) {}

    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add products before checkout.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $data = $request->validated();

        if ($request->boolean('shipping_same_as_billing', true)) {
            $data['shipping_name'] = $data['name'];
            $data['shipping_address'] = $data['address'];
            $data['shipping_city'] = $data['city'];
            $data['shipping_state'] = $data['state'];
            $data['shipping_zip'] = $data['zip'];
            $data['shipping_country'] = $data['country'];
        }

        try {
            $order = $this->checkoutService->process($cart, $request->user(), $data);

            return redirect()->route('checkout.success', $order)
                ->with('success', 'Order placed successfully!');
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function success(int $order): View
    {
        $order = auth()->user()->orders()->with('items.product')->findOrFail($order);

        return view('checkout.success', compact('order'));
    }
}
