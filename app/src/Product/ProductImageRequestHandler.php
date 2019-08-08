<?php

namespace App\Product;

use App\Entity\Media;
use App\Entity\Product;
use App\Media\MediaFactory;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductImageRequestHandler
{
    private $mediaFactory;

    private $productService;

    private $fileUploader;

    private $uri;

    public function __construct(
        FileUploader $fileUploader,
        MediaFactory $mediaFactory,
        ProductService $productService,
        string $uri
    ) {
        $this->mediaFactory = $mediaFactory;
        $this->productService = $productService;
        $this->fileUploader = $fileUploader;
        $this->uri = $uri;
    }

    public function add(Product $product, UploadedFile $file): Media
    {
        $this->fileUploader->setTargetDirectory('/public'.$this->uri);
        $file = $this->fileUploader->upload($file);
        $image = $this->mediaFactory->createFromFile($file);
        $image->setUri($this->uri.'/'.$file->getName());
        $product->addImage($image);
        $this->productService->updateProduct($product);

        return $image;
    }
}
