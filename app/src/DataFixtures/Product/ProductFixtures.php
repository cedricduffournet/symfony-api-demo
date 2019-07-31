<?php

namespace App\DataFixtures\Product;

use App\DataFixtures\CustomNativeLoader;
use App\Service\ProductServiceInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadProducts();
    }

    private function loadProducts(): void
    {
        $loader = new CustomNativeLoader();
        $objectSet = $loader->loadFile(__DIR__.'/Data/products.yaml')->getObjects();
        foreach ($objectSet as $object) {
            $this->productService->updateProduct($object);
        }
    }

    public static function getGroups(): array
    {
        return ['product'];
    }

    public function getDependencies(): array
    {
        return [
            ProductCategoryFixtures::class,
        ];
    }
}
