<?php

namespace App\Product;

use App\Entity\Product;

interface ProductServiceInterface
{
    public function createProduct(): Product;

    public function getProduct(int $productId): Product;

    public function getAllProducts(): array;

    public function updateProduct(Product $product): void;

    public function deleteProduct(Product $product): void;
}
