<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Book;
use App\Exception\BookCategoryNotFoundException;
use App\Model\BookListResponse;
use App\Model\DTO\BookListItem;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;
use App\Service\BookService;
use App\Tests\AbstractCaseTest;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\Exception;
use ReflectionException;

class BookServiceTest extends AbstractCaseTest
{
    /**
     * @throws Exception
     */
    public function testGetBookByCategoryNotFound(): void
    {
        $bookRepository = $this->createMock(BookRepository::class);
        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $bookCategoryRepository
            ->expects(self::once())
            ->method('existsById')
            ->with(140)
            ->willReturn(false);

        $this->expectException(BookCategoryNotFoundException::class);

        (new BookService($bookRepository, $bookCategoryRepository))->getBookByCategory(140);
    }

    /**
     * @throws Exception
     * @throws ReflectionException
     */
    public function testSuccessBookByCategory(): void
    {
        $bookRepository = $this->createMock(BookRepository::class);
        $bookRepository
            ->expects(self::once())
            ->method('findBooksByCategoryId')
            ->with(7)
            ->willReturn($this->createBookEntity());

        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $bookCategoryRepository
            ->expects(self::once())
            ->method('existsById')
            ->with(7)
            ->willReturn(true);

        $service = (new BookService($bookRepository, $bookCategoryRepository));
        $expected = new BookListResponse([$this->createBookitemList()]);

        self::assertEquals($expected, $service->getBookByCategory(140));
    }

    /**
     * @return Book
     * @throws ReflectionException
     */
    private function createBookEntity(): Book
    {
        $book = (new Book())
            ->setTitle('Test title')
            ->setSlug('Test slug')
            ->setImage('Testimage')
            ->setMeap(false)
            ->setDate((new DateTime('2024-12-12')))
            ->setAuthors(['ewffewfew', 'fwefewf'])
            ->setCategories(new ArrayCollection(['ewfewfew']));

        $this->setEntityId($book, 15);

        return $book;
    }

    /**
     * @return BookListItem
     * @throws ReflectionException
     */
    private function createBookitemList(): BookListItem
    {
        $bookItems = (new BookListItem())
            ->setTitle('Test title')
            ->setSlug('Test slug')
            ->setImage('Testimage')
            ->setMeap(false)
            ->setDate(324543)
            ->setAuthors(['ewffewfew', 'fwefewf'])
            ->setCategories(['ewfewfew']);

        $this->setEntityId($bookItems, 15);

        return $bookItems;
    }
}
