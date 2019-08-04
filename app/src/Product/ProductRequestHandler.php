<?php

namespace App\Product;

use App\Entity\Product;

class ProductRequestHandler
{
    private $productFactory;
    private $productService;

    public function __construct(ProductFactory $productFactory, ProductService $productService)
    {
        $this->productFactory = $productFactory;
        $this->productService = $productService;
    }

    public function addProduct(ProductRequest $productRequest): Product
    {
        $product = $this->productFactory->createFromProductRequest($productRequest);
        $this->productService->updateProduct($product);

        return $product;
    }

    public function updateProduct(ProductRequest $productRequest, Product $product): void
    {
        $product->update($productRequest);
        $this->productService->updateProduct($product);
    }
}
