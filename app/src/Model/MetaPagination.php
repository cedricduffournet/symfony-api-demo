<?php

namespace App\Model;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class MetaPagination
{
    /**
     * Current page.
     *
     * @var int
     * @Type("int")
     */
    private $page;

    /**
     * Total pages.
     *
     * @var int
     * @Type("int")
     * @SerializedName("pageCount")
     */
    private $pageCount;

    /**
     * Number items per page.
     *
     * @var int
     * @Type("int")
     * @SerializedName("itemsPerPage")
     */
    private $itemsPerPage;

    /**
     * Total items.
     *
     * @var int
     * @Type("int")
     * @SerializedName("totalItems")
     */
    private $totalItems;

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPageCount(int $pageCount): void
    {
        $this->pageCount = $pageCount;
    }

    public function getPageCount(): ?int
    {
        return $this->pageCount;
    }

    public function setItemsPerPage(int $itemsPerPage): void
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    public function getItemsPerPage(): ?int
    {
        return $this->itemsPerPage;
    }

    public function setTotalItems(int $totalItems): void
    {
        $this->totalItems = $totalItems;
    }

    public function getTotalItems(): ?int
    {
        return $this->totalItems;
    }
}
