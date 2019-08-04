<?php

namespace App\Product;

use App\Entity\Product;

class ProductFactory
{
    public function createFromProductRequest(ProductRequest $request): Product
    {
        return Product::create($request->name, $request->description, $request->price, $request->categories);
    }
}
