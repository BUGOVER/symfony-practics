<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\BookListItem;

class BookListResponse
{
    /**
     * @var BookListItem[]
     */
    private array $items;

    /**
     * @param BookListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return BookListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
