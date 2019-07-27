<?php

namespace App\Entity;

use App\Model\ProductCategoryInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_category")
 *
 * Define the properties of the ProductCategory entity
 */
class ProductCategory implements ProductCategoryInterface
{
    /**
     * ProductCategory id.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"Default"})
     */
    private $id;

    /**
     * ProductCategory name.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"Default"})
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
