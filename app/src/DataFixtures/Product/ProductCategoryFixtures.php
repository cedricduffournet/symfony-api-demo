<?php

namespace App\DataFixtures\Product;

use App\Service\ProductCategoryServiceInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductCategoryFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @var ProductCategoryService
     */
    private $productCategoryService;

    public function __construct(ProductCategoryServiceInterface $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadProductCategories();
    }

    private function loadProductCategories(): void
    {
        $productCategories = $this->getProductCategories();

        foreach ($productCategories as $value) {
            $productCategory = $this->productCategoryService->createProductCategory();
            $productCategory->setName($value['name']);
            $this->productCategoryService->updateProductCategory($productCategory);
            $this->addReference('product-category-'.$value['reference'], $productCategory);
        }
    }

    private function getProductCategories(): array
    {
        return [
                ['reference' => 1, 'name' => 'Category 1'],
                ['reference' => 2, 'name' => 'Category 2'],
                ['reference' => 3, 'name' => 'Category 3'],
        ];
    }

    public static function getGroups(): array
    {
        return ['product'];
    }
}
