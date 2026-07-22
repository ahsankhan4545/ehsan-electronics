<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->productRepository->paginate($filters);
    }

    public function featured(int $limit = 8): Collection
    {
        return $this->productRepository->featured($limit);
    }

    public function findBySlug(string $slug): ?Product
    {
        return $this->productRepository->findBySlug($slug);
    }

    public function find(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    public function create(array $data, ?UploadedFile $image = null): Product
    {
        if ($image) {
            $data['image_path'] = $this->storeImage($image);
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data, ?UploadedFile $image = null): Product
    {
        if ($image) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $this->storeImage($image);
        }

        return $this->productRepository->update($product, $data);
    }

    public function delete(Product $product): bool
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        return $this->productRepository->delete($product);
    }

    private function storeImage(UploadedFile $image): string
    {
        return $image->store('products', 'public');
    }
}
