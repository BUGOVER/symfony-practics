<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\BookCategory;
use App\Repository\BookCategoryRepository;
use App\Tests\AbstractKernelTest;
use Doctrine\ORM\Exception\ORMException;

class BookCategoryRepositoryTest extends AbstractKernelTest
{
    private BookCategoryRepository $bookCategoryRepository;

    /**
     * @throws ORMException
     */
    public function testFindAllSortedByTitle(): void
    {
        $android = (new BookCategory())->setTitle('Device on linux')->setSlug('device_on_linux');
        $apple = (new BookCategory())->setTitle('Device on unix')->setSlug('device_on_unix');
        $windows = (new BookCategory())->setTitle('Device on windows')->setSlug('device_on_windows');

        foreach ([$android, $apple, $windows] as $category) {
            $this->em->persist($category);
        }
        $this->em->flush();

        $expected = ['Device on linux', 'Device on unix', 'Device on windows'];
        $actualTitles = array_map(
            static fn (BookCategory $bookCategory) => $bookCategory->getTitle(),
            $this->bookCategoryRepository->findAllSortedByTitle()
        );

        self::assertEquals($expected, $actualTitles);
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->bookCategoryRepository = $this->getRepositoryByEntity(BookCategory::class);
    }
}
