<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;
use App\Tests\Controller\Schemas\BookControllerSchemas;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Helmich\JsonAssert\JsonAssertions;
use JsonException;

class BookControllerTest extends AbstractControllerTest
{
    use BookControllerSchemas;
    use JsonAssertions;

    /**
     * @return void
     * @throws JsonException
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testInValidBookByCategory(): void
    {
        $category_id = $this->createBooks();

        $this->client->request('GET', "/api/v1/category/$category_id/books");
        $responseContent = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertJsonDocumentMatchesSchema($responseContent, $this->testInValidBookByCategory);
    }

    /**
     * @return int
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function createBooks(): int
    {
        $bookCategory = (new BookCategory())->setTitle('Android')->setSlug('android');
        $this->em->persist((new Book())->setTitle('test')->setSlug('test')->setMeap(true)->setAuthors(['authors'])->setDate(new DateTime('2024-12-12'))->setImage('image')->setCategories(new ArrayCollection([$bookCategory])));
        $this->em->flush();

        return $bookCategory->getId();
    }
}
