<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService,
    ) {}

    public function index(): View
    {
        $orders = $this->orderService->forUser(auth()->user());

        return view('orders.index', compact('orders'));
    }

    public function show(int $order): View
    {
        $order = $this->orderService->findForUser(auth()->user(), $order);

        abort_if(! $order, 404);

        return view('orders.show', compact('order'));
    }
}
