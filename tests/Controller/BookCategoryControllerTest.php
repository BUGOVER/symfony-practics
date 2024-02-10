<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookCategoryControllerTest extends WebTestCase
{

    public function testCategories()
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/categories');
        $responseContent = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertJsonStringEqualsJsonFile(
            __DIR__ . '/responses/BookCategoriesControllerTest_testCategories.json',
            $responseContent
        );
    }
}
