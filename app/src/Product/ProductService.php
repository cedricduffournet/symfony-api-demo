<?php

namespace App\Product;

use App\Entity\Product;
use App\Model\ProductsPaginated;
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

    public function searchProduct(array $options = []): ProductsPaginated
    {
        $products = $this->productRepository->search($options);

        return new ProductsPaginated($products);
    }
}
