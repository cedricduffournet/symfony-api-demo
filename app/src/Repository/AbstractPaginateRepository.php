<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractPaginateRepository
{
    protected function paginate(Query $qb, int $limit = 20, int $offset = 0): Pagerfanta
    {
        if (0 == $limit || 0 == $offset) {
            throw new \LogicException('$limit & $offstet must be greater than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));

        $pager->setMaxPerPage($limit);
        $pager->setCurrentPage($offset);

        return $pager;
    }
}
