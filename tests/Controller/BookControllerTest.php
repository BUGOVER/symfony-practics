<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testInValidBookByCategory()
    {
        $categoryId = '';

        $client = static::createClient();
        $client->request('GET', "/api/v1/category/$categoryId/books");
        $responseContent = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertJsonStringEqualsJsonFile(
            __DIR__ . '/responses/BookControllerTest_testBooksByCategory.json',
            $responseContent
        );
    }
}
