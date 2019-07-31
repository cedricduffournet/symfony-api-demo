<?php

namespace App\Model;

use Pagerfanta\Pagerfanta;

abstract class AbstractPaginateResult
{
    protected $data = [];

    /**
     * @var MetaPagination
     */
    protected $meta;

    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();

        $this->meta = new MetaPagination();

        $this->meta->setPage($data->getCurrentPage());
        $this->meta->setPageCount($data->getNbPages());
        $this->meta->setItemsPerPage($data->getMaxPerPage());
        $this->meta->setTotalItems($data->getNbResults());
    }
}
