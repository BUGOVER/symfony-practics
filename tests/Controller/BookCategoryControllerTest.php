<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;
use App\Tests\Controller\Schemas\BookCategoryControllerSchemas;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Helmich\JsonAssert\JsonAssertions;
use JsonException;

class BookCategoryControllerTest extends AbstractControllerTest
{
    use JsonAssertions;
    use BookCategoryControllerSchemas;

    /**
     * @return void
     * @throws JsonException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testCategories(): void
    {
        $this->em->persist((new BookCategory())->setTitle('Android')->setSlug('android'));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/categories');
        $response_content = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertJsonDocumentMatchesSchema(
            $response_content,
            $this->testCategoriesSchema
        );
    }
}
