<?php

namespace App\ProductCategory;

use App\Entity\ProductCategory;

class ProductCategoryRequestHandler
{
    private $productCategoryFactory;
    private $productCategoryService;

    public function __construct(ProductCategoryFactory $productCategoryFactory, ProductCategoryService $productCategoryService)
    {
        $this->productCategoryFactory = $productCategoryFactory;
        $this->productCategoryService = $productCategoryService;
    }

    public function addProductCategory(ProductCategoryRequest $productCategoryRequest): ProductCategory
    {
        $productCategory = $this->productCategoryFactory->createFromProductCategoryRequest($productCategoryRequest);
        $this->productCategoryService->updateProductCategory($productCategory);

        return $productCategory;
    }

    public function updateProductCategory(ProductCategoryRequest $productCategoryRequest, ProductCategory $productCategory): void
    {
        $productCategory->update($productCategoryRequest);
        $this->productCategoryService->updateProductCategory($productCategory);
    }
}
