<?php

namespace App\Service;

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepositoryInterface;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    /**
     * @var ProductCategoryRepository
     */
    private $productCategoryRepository;

    public function __construct(ProductCategoryRepositoryInterface $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function createProductCategory(): ProductCategory
    {
        return new ProductCategory();
    }

    public function getProductCategory(int $productCategoryId): ProductCategory
    {
        return $this->productCategoryRepository->find($productCategoryId);
    }

    public function getAllProductCategories(): array
    {
        return $this->productCategoryRepository->findAll();
    }

    public function updateProductCategory(ProductCategory $productCategory): void
    {
        $this->productCategoryRepository->save($productCategory);
    }

    public function deleteProductCategory(ProductCategory $productCategory): void
    {
        $this->productCategoryRepository->remove($productCategory);
    }
}
