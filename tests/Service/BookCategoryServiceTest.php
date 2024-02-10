<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\DTO\BookCategoryListItem;
use App\Entity\BookCategory;
use App\Model\BookCategoryListResponse;
use App\Repository\BookCategoryRepository;
use App\Service\BookCategoryService;
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class BookCategoryServiceTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testGetCategories(): void
    {
        $repository = $this->createMock(BookCategoryRepository::class);
        $repository
            ->expects(static::once())
            ->method('findBy')
            ->with([], ['title' => Criteria::ASC])
            ->willReturn((new BookCategory())->setId(7)->setTitle('example')->setSlug('test'));

        $service = new BookCategoryService($repository);
        $expected = new BookCategoryListResponse([new BookCategoryListItem(7, 'example', 'test')]);

        static::assertEquals($expected, $service->getCategories());
    }
}
