<?php

namespace App\Model;

use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;

class ProductsPaginated extends AbstractPaginateResult
{
    /**
     * @Type("array<App\Entity\Product>")
     * @Groups({"Default"})
     */
    public $data;

    /**
     * @Type("App\Model\MetaPagination")
     * @Groups({"Default"})
     */
    public $meta;
}
