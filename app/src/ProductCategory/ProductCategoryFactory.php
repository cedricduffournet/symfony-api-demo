<?php

namespace App\ProductCategory;

use App\Entity\ProductCategory;

class ProductCategoryFactory
{
    public function createFromProductCategoryRequest(ProductCategoryRequest $request): ProductCategory
    {
        return ProductCategory::create($request->name);
    }
}
