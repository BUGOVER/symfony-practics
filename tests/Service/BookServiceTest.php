<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Exception\BookCategoryNotFoundException;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class BookServiceTest extends TestCase
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
            ->method('find')
            ->with(130)
            ->willThrowException(new BookCategoryNotFoundException());

        $this->expectException(BookCategoryNotFoundException::class);
    }
}
