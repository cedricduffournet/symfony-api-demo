<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Media.
 *
 * @ORM\Entity
 * @ORM\Table(name="media")
 */
class Media
{
    /**
     * Media id.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Media name.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Media original name.
     *
     * @var string
     *
     * @ORM\Column(name="original_name", type="string", length=255)
     * @Exclude
     */
    private $originalName;

    /**
     * Media absolute path.
     *
     * @var string
     *
     * @ORM\Column(name="directory", type="string", length=255)
     * @Exclude
     */
    private $directory;

    /**
     * Media url.
     *
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=255)
     */
    private $uri;

    /**
     * Media update date.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @SerializedName("updatedAt")
     * @Gedmo\Timestampable(on="update")
     * @Exclude
     */
    private $updatedAt;

    /**
     * Media created date.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @SerializedName("createdAt")
     * @Gedmo\Timestampable(on="create")
     * @Exclude
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=10)
     * @Exclude
     */
    private $extension;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     * @Exclude
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="mime_type", type="string")
     * @SerializedName("mimeType")
     * @Exclude
     */
    private $mimeType;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Exclude
     */
    private $product;

    public static function create(
        string $name,
        string $originalName,
        string $extension,
        string $directory,
        int $size,
        string $mimeType
    ): self {
        $media = new self();

        $media->name = $name;
        $media->originalName = $originalName;
        $media->extension = $extension;
        $media->directory = $directory;
        $media->size = $size;
        $media->mimeType = $mimeType;

        return $media;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function setDirectory(string $directory): void
    {
        $this->directory = $directory;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    public function getSize(): int
    {
        return $this->extension;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}
