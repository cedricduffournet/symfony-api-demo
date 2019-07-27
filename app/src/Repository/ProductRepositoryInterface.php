<?php

namespace App\Repository;

use App\Entity\Product;

interface ProductRepositoryInterface
{
    public function find(int $productId): Product;

    public function findAll(): array;

    public function remove(Product $product): void;

    public function save(Product $product): void;
}
