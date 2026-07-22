<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService,
        private OrderService $orderService,
    ) {}

    public function index(): View
    {
        return view('admin.dashboard', [
            'productCount' => $this->productService->paginate()->total(),
            'categoryCount' => $this->categoryService->all()->count(),
            'recentOrders' => $this->orderService->paginateForAdmin(),
        ]);
    }
}
