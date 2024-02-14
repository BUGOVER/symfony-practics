<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\BookCategory;
use App\Model\BookCategoryListResponse;
use App\Model\DTO\BookCategoryListItem;
use App\Repository\BookCategoryRepository;
use App\Service\BookCategoryService;
use App\Tests\AbstarctTestCase;
use PHPUnit\Framework\MockObject\Exception;
use ReflectionException;

class BookCategoryServiceTest extends AbstarctTestCase
{
    /**
     * @return void
     * @throws Exception
     * @throws ReflectionException
     */
    public function testGetCategories(): void
    {
        $category = (new BookCategory())->setTitle('example')->setSlug('test');
        $this->setEntityId($category, 15);

        $repository = $this->createMock(BookCategoryRepository::class);
        $repository
            ->expects(static::once())
            ->method('findAllSortedByTitle')
            ->willReturn([$category]);

        $service = new BookCategoryService($repository);
        $expected = new BookCategoryListResponse([
            (new BookCategoryListItem())
                ->setId(15)
                ->setTitle('example')
                ->setSlug('test')
        ]);

        static::assertEquals($expected, $service->getCategories());
    }
}
