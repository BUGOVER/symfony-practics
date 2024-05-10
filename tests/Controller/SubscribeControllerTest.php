<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;
use Helmich\JsonAssert\JsonAssertions;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response;

class SubscribeControllerTest extends AbstractControllerTest
{
    use JsonAssertions;

    /**
     * @throws \JsonException|\Random\RandomException
     */
    public function testSubscribe(): void
    {
        $content = json_encode(
            [
                'email' => random_int(1, 100) . 'test1@gmail.com',
                'agreed' => true,
            ],
            JSON_THROW_ON_ERROR
        );
        $this->client->request(
            method: 'POST',
            uri: '/api/v1/subscribe',
            parameters: ['Content-Type' => 'text/xml; charset=UTF8'],
            content: $content
        );

        self::assertResponseIsSuccessful();
    }

    /**
     * @throws RandomException
     * @throws \JsonException
     */
    public function testSubscribtionAgreed(): void
    {
        $content = json_encode(
            [
                'email' => random_int(1, 100) . 'test1@gmail.com',
            ],
            JSON_THROW_ON_ERROR
        );
        $this->client->request(
            method: 'POST',
            uri: '/api/v1/subscribe',
            parameters: ['Content-Type' => 'text/xml; charset=UTF8'],
            content: $content
        );

        $response_content = json_decode($this->client->getResponse()->getContent(), false, 512, JSON_THROW_ON_ERROR);
        static::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertJsonDocumentMatches($response_content, [
            '$.message' => 'validation failed',
            '$.details.violations' => self::countOf(1),
            '$.details.violations.[0].field' => 'agreed',
        ]);
    }
}
