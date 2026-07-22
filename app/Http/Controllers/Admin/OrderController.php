<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderPaymentRequest;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService,
    ) {}

    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => $this->orderService->paginateForAdmin(),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $this->orderService->updateStatus($order, $request->validated('status'));

        return back()->with('success', 'Order status updated successfully.');
    }

    public function updatePaymentStatus(UpdateOrderPaymentRequest $request, Order $order): RedirectResponse
    {
        $this->orderService->updatePaymentStatus($order, $request->validated('payment_status'));

        return back()->with('success', 'Payment status updated successfully.');
    }
}
