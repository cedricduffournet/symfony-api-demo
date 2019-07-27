<?php

namespace App\Model;

use Money\Money;

interface ProductInterface
{
    public function getId(): ?int;

    public function setName(string $name): void;

    public function getName(): ?string;

    public function setDescription(string $description): void;

    public function getDescription(): ?string;

    public function setPrice(Money $price): void;

    public function getPrice(): ?Money;
}
