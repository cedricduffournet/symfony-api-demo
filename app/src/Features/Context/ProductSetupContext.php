<?php

namespace App\Features\Context;

use App\ProductCategory\ProductCategoryServiceInterface;
use App\Service\ProductServiceInterface;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Money\Currency;
use Money\Money;

class ProductSetupContext implements Context, SnippetAcceptingContext
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductServiceInterface $productService, ProductCategoryServiceInterface $productCategoryService)
    {
        $this->productService = $productService;
        $this->productCategoryService = $productCategoryService;
    }

    /**
     * @Given there are Products with the following details:
     */
    public function thereAreProductsWithTheFollowingDetails(TableNode $products): void
    {
        foreach ($products->getColumnsHash() as $key => $val) {
            $product = $this->productService->createProduct();
            $product->setName($val['name']);
            $product->setDescription($val['description']);
            $money = new Money((int) $val['priceAmount'], new Currency($val['priceCurrency']));
            $product->setPrice($money);
            $aCategories = explode(',', $val['categories']);
            foreach ($aCategories as $value) {
                $category = $this->productCategoryService->getProductCategory((int) $value);
                $product->addCategory($category);
            }
            $this->productService->updateProduct($product);
        }
    }
}
