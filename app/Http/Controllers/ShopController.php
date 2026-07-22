<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService,
    ) {}

    public function index(Request $request): View
    {
        return view('shop.index', [
            'products' => $this->productService->paginate([
                'category' => $request->query('category'),
                'search' => $request->query('search'),
            ]),
            'categories' => $this->categoryService->all(),
            'activeCategory' => $request->query('category'),
            'search' => $request->query('search'),
        ]);
    }

    public function show(string $slug): View
    {
        $product = $this->productService->findBySlug($slug);

        abort_if(! $product, 404);

        return view('shop.show', compact('product'));
    }
}
