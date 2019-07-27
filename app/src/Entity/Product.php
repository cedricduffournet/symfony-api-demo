<?php

namespace App\Entity;

use App\Model\ProductInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Money\Currency;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 *
 * Define the properties of the Product entity
 */
class Product implements ProductInterface
{
    /**
     * Product id.
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
     * Product name.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"Default","user_info"})
     */
    private $name;

    /**
     * Product description.
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank
     * @Groups({"Default"})
     */
    private $description;

    /**
     * Product price amount.
     *
     * @var int
     *
     * @ORM\Column(name="price_amount", type="integer")
     * @SerializedName("priceAmount")
     * @Groups({"Default"})
     */
    private $priceAmount;

    /**
     * Product price amount.
     *
     * @var string
     *
     * @ORM\Column(name="price_currency", type="string", length=64)
     * @SerializedName("priceCurrency")
     * @Groups({"Default"})
     */
    private $priceCurrency;

    /**
     * Product categories.
     *
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductCategory")
     * @Groups({"Default"})
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setPrice(Money $price): void
    {
        $this->priceAmount = $price->getAmount();
        $this->priceCurrency = $price->getCurrency()->getName();
    }

    public function getPrice(): ?Money
    {
        if (!$this->priceCurrency) {
            return null;
        }

        if (!$this->priceAmount) {
            return new Money(0, new Currency($this->priceCurrency));
        }

        return new Money($this->priceAmount, new Currency($this->priceCurrency));
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(ProductCategory $productCategory): void
    {
        if ($this->categories->contains($productCategory)) {
            return;
        }
        $this->categories[] = $productCategory;
    }

    public function removeCategory(ProductCategory $productCategory)
    {
        $this->categories->removeElement($productCategory);
    }
}
