<?php

namespace App\Repository;

use App\Entity\ProductCategory;

interface ProductCategoryRepositoryInterface
{
    public function find(int $productCategoryId): ProductCategory;

    public function findAll(): array;

    public function remove(ProductCategory $productCategory): void;

    public function save(ProductCategory $productCategory): void;
}
