<?php

namespace App\Features\Context;

use App\ProductCategory\ProductCategoryServiceInterface;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;

class ProductCategorySetupContext implements Context, SnippetAcceptingContext
{
    /**
     * @var ProductCategoryService
     */
    private $productCategoryService;

    public function __construct(ProductCategoryServiceInterface $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    /**
     * @Given there are ProductCategories with the following details:
     */
    public function thereAreProductCategoriesWithTheFollowingDetails(TableNode $productCategories): void
    {
        foreach ($productCategories->getColumnsHash() as $key => $val) {
            $productCategory = $this->productCategoryService->createProductCategory();
            $productCategory->setName($val['name']);
            $this->productCategoryService->updateProductCategory($productCategory);
        }
    }
}
