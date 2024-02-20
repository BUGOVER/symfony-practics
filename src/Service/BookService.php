<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Book;
use App\Exception\BookCategoryNotFoundException;
use App\Model\BookListResponse;
use App\Model\DTO\BookListItem;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;

class BookService
{
    /**
     * @param BookRepository $bookRepository
     * @param BookCategoryRepository $bookCategoryRepository
     */
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly BookCategoryRepository $bookCategoryRepository,
    ) {
    }

    /**
     * @param int $category_id
     * @return BookListResponse
     */
    public function getBookByCategory(int $category_id): BookListResponse
    {
        if (!$this->bookCategoryRepository->existsById($category_id)) {
            throw new BookCategoryNotFoundException();
        }

        $books = $this->bookRepository->findBooksByCategoryId($category_id);

        return new BookListResponse(
            array_map(
                [$this, 'map'],
                $books
            )
        );
    }

    /**
     * @param Book $book
     * @return BookListItem
     */
    private function map(Book $book): BookListItem
    {
        return (new BookListItem())
            ->setId($book->getId())
            ->setSlug($book->getSlug())
            ->setTitle($book->getTitle())
            ->setAuthors((array)$book->getAuthors())
            ->setImage($book->getImage())
            ->setMeap($book->isMeap())
            ->setDate($book->getDate()->getTimestamp());
    }
}
