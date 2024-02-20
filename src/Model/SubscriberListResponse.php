<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\DTO\BookCategoryListItem;

class SubscriberListResponse
{
    /**
     * @var BookCategoryListItem[]
     */
    private array $items;

    /**
     * @param BookCategoryListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return BookCategoryListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
