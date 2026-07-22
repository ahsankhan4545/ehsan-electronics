<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with('category');

        if (! empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function featured(int $limit = 8): Collection
    {
        return Product::with('category')
            ->where('is_featured', true)
            ->where('stock', '>', 0)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function find(int $id): ?Product
    {
        return Product::with('category')->find($id);
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::with('category')->where('slug', $slug)->first();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->fresh(['category']);
    }

    public function delete(Product $product): bool
    {
        return (bool) $product->delete();
    }

    public function decrementStock(Product $product, int $quantity): bool
    {
        if ($product->stock < $quantity) {
            return false;
        }

        $product->decrement('stock', $quantity);

        return true;
    }
}
