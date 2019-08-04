<?php

namespace App\Product;

use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

class ProductRequest
{
    /**
     * Product name.
     *
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 255
     * )
     */
    public $name;

    /**
     * Product description.
     *
     * @var string
     *
     * @Assert\NotBlank
     */
    public $description;

    /**
     * Product price amount.
     *
     * @var Money
     *
     * @Assert\NotBlank
     */
    public $price;

    public $categories;

    public static function createFromProduct(Product $product): self
    {
        $dto = new self();
        $dto->name = $product->getName();
        $dto->description = $product->getDescription();
        $dto->price = $product->getPrice();
        $dto->categories = $product->getCategories();

        return $dto;
    }
}
