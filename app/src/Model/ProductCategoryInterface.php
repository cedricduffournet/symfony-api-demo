<?php

namespace App\Model;

interface ProductCategoryInterface
{
    public function getId(): ?int;

    public function setName(string $name): void;

    public function getName(): ?string;
}
