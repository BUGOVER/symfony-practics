<?php

declare(strict_types=1);

namespace App\Model\DTO;

class BookCategoryListItem
{
    private int $id;

    private string $title;

    private string $slug;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): BookCategoryListItem
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): BookCategoryListItem
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): BookCategoryListItem
    {
        $this->slug = $slug;

        return $this;
    }
}
