<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    public function boot(): void
    {
        View::composer('components.layouts.store', function ($view) {
            try {
                $view->with('cartItemCount', app(CartService::class)->itemCount());
            } catch (\Throwable $e) {
                $view->with('cartItemCount', 0);
            }

            try {
                $view->with('navCategories', app(CategoryRepositoryInterface::class)->all());
            } catch (\Throwable $e) {
                $view->with('navCategories', collect());
            }

            $unread = 0;
            if (auth()->check()) {
                $unread = auth()->user()->unreadNotifications()->count();
            }
            $view->with('unreadNotifications', $unread);
        });
    }
}
