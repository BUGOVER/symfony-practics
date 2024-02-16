<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Repository\BookRepository;
use App\Tests\AbstractKernelTest;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;

class BookRepositoryTest extends AbstractKernelTest
{
    protected BookRepository $bookRepository;

    /**
     * @throws ORMException
     */
    public function testFindBooksByCategoryId(): void
    {
        $devisesCategory = (new BookCategory())->setTitle('Test title')->setSlug('test slug');
        $this->em->persist($devisesCategory);

        for ($i = 0; $i < 5; ++$i) {
            $book = $this->createBook('device-' . $i, $devisesCategory);
            $this->em->persist($book);
        }
        $this->em->flush();

        self::assertCount(5, $this->bookRepository->findBooksByCategoryId($devisesCategory->getId()));
    }

    /**
     * @param string $title
     * @param BookCategory $bookCategory
     * @return Book
     */
    private function createBook(string $title, BookCategory $bookCategory): Book
    {
        return (new Book())
            ->setTitle($title)
            ->setDate(new DateTime())
            ->setAuthors(['author'])
            ->setSlug('test slug')
            ->setMeap(false)
            ->setCategories(new ArrayCollection([$bookCategory]));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->getRepositoryByEntity(Book::class);
    }
}
