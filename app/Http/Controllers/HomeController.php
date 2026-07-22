<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService,
    ) {}

    public function index(): View
    {
        return view('home.index', [
            'featuredProducts' => $this->productService->featured(),
            'categories' => $this->categoryService->all(),
        ]);
    }
}
