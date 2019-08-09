<?php

namespace App\Model;

class File
{
    private $extension;

    private $name;

    private $size;

    private $targetDirectory;

    private $originalName;

    private $mimeType;

    public function __construct(
        string $name = '',
        string $extension = '',
        int $size = 0,
        string $targetDirectory = '',
        string $originalName = '',
        string $mimeType = ''
    ) {
        $this->name = $name;
        $this->extension = $extension;
        $this->size = $size;
        $this->targetDirectory = $targetDirectory;
        $this->originalName = $originalName;
        $this->mimeType = $mimeType;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setTargetDirectory(string $targetDirectory): void
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
