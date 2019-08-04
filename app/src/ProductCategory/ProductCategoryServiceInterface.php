<?php

namespace App\ProductCategory;

use App\Entity\ProductCategory;

interface ProductCategoryServiceInterface
{
    public function createProductCategory(): ProductCategory;

    public function getProductCategory(int $productCategoryId): ProductCategory;

    public function getAllProductCategories(): array;

    public function updateProductCategory(ProductCategory $productCategory): void;

    public function deleteProductCategory(ProductCategory $productCategory): void;
}
