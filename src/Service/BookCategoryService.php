<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\BookCategory;
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

        return new BookCategoryListResponse(array_map(
            [$this, 'map'],
            $categories
        ));
    }

    /**
     * @param BookCategory $bookCategory
     * @return BookCategoryListItem
     */
    private function map(BookCategory $bookCategory): BookCategoryListItem
    {
        return (new BookCategoryListItem())
            ->setId($bookCategory->getId())
            ->setTitle($bookCategory->getTitle())
            ->setSlug($bookCategory->getSlug());
    }
}
