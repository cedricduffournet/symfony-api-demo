<?php

namespace App\Entity;

use App\Model\ProductInterface;
use App\Product\ProductRequest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
     */
    private $name;

    /**
     * Product description.
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * Product price amount.
     *
     * @var int
     *
     * @ORM\Column(name="price_amount", type="integer")
     * @SerializedName("priceAmount")
     */
    private $priceAmount;

    /**
     * Product price amount.
     *
     * @var string
     *
     * @ORM\Column(name="price_currency", type="string", length=64)
     * @SerializedName("priceCurrency")
     */
    private $priceCurrency;

    /**
     * Product categories.
     *
     * @var ProductCategory[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductCategory")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public static function create(string $name, string $description, Money $price, iterable $categories): self
    {
        $product = new self();

        $product->name = $name;
        $product->description = $description;
        $product->categories = $categories;
        $product->setPrice($price);

        return $product;
    }

    public function update(ProductRequest $productRequest): void
    {
        $this->name = $productRequest->name;
        $this->description = $productRequest->description;
        $this->categories = $productRequest->categories;
        $this->setPrice($productRequest->price);
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
