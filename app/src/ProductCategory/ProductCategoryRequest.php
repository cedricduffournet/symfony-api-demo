<?php

namespace App\ProductCategory;

use App\Entity\ProductCategory;
use Symfony\Component\Validator\Constraints as Assert;

class ProductCategoryRequest
{
    /**
     * ProductCategory name.
     *
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 255
     * )
     */
    public $name;

    public static function createFromProductCategory(ProductCategory $productCategory): self
    {
        $dto = new self();
        $dto->name = $productCategory->getName();

        return $dto;
    }
}
