<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(): Product
    {
        return new Product();
    }

    public function getProduct(int $productId): Product
    {
        return $this->productRepository->find($productId);
    }

    public function getAllProducts(): array
    {
        return $this->productRepository->findAll();
    }

    public function updateProduct(Product $product): void
    {
        $this->productRepository->save($product);
    }

    public function deleteProduct(Product $product): void
    {
        $this->productRepository->remove($product);
    }
}
