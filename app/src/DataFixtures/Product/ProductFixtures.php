<?php

namespace App\DataFixtures\Product;

use App\DataFixtures\CustomNativeLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $loader = new CustomNativeLoader();
        $objectSet = $loader->loadFile(__DIR__.'/Data/products.yaml')->getObjects();
        foreach ($objectSet as $object) {
            $manager->persist($object);
            $manager->flush();
        }
    }

    public static function getGroups(): array
    {
        return ['product'];
    }
}
