<?php

namespace App\Repository;

use App\Entity\Product;
use Pagerfanta\Pagerfanta;

interface ProductRepositoryInterface
{
    public function find(int $productId): Product;

    public function findAll(): array;

    public function remove(Product $product): void;

    public function save(Product $product): void;

    public function search(array $options = []): Pagerfanta;
}
