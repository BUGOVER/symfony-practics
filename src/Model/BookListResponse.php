<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\BookListItem;

class BookListResponse
{
    /**
     * @param BookListItem[] $items
     */
    public function __construct(private readonly array $items)
    {
    }

    /**
     * @return BookListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
