<?php

declare(strict_types=1);

namespace App\Controller;

use App\Attributes\RequestBody;
use App\Model\ErrorResponse;
use App\Request\SubscriberRequest;
use App\Service\SubscriberService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SubscribeController extends AbstractController
{
    /**
     * @param SubscriberService $subscriberService
     */
    public function __construct(private readonly SubscriberService $subscriberService)
    {
    }

    #[
        OA\Attributes\Response(
            response: 200,
            description: 'Subscribe on email',
            content: new Model(type: SubscriberRequest::class)
        ),
        OA\Attributes\Response(
            response: 403,
            description: 'validation failed',
            attachables: [new Model(type: ErrorResponse::class)]
        ),
        OA\Attributes\RequestBody(attachables: [new Model(type: SubscriberRequest::class)])
    ]
    #[Route(
        path: '/api/v1/subscribe',
        methods: ['POST']
    )]
    public function subscribe(#[RequestBody] SubscriberRequest $request): JsonResponse
    {
        $this->subscriberService->subscribe($request);

        return $this->json(['message' => 'Subscription successful']);
    }
}
