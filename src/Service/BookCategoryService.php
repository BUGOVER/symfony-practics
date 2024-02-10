<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\BookCategoryListResponse;
use App\Model\DTO\BookCategoryListItem;
use App\Repository\BookCategoryRepository;
use Doctrine\Common\Collections\Criteria;

class BookCategoryService
{
    /**
     * @param BookCategoryRepository $categoryRepository
     */
    public function __construct(private readonly BookCategoryRepository $categoryRepository)
    {
    }

    /**
     * @return BookCategoryListResponse
     */
    public function getCategories(): BookCategoryListResponse
    {
        $categories = $this->categoryRepository->findBy([], ['title' => Criteria::ASC]);
        $items = array_map(
            static fn($item) => new BookCategoryListItem($item->getId(), $item->getTitle(), $item->getSlug()),
            $categories
        );

        return new BookCategoryListResponse($items);
    }
}
