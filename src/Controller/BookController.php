<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\BookListResponse;
use App\Model\ErrorResponse;
use App\Service\BookService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    /**
     * @param BookService $bookService
     */
    public function __construct(private readonly BookService $bookService)
    {
    }

    #[
        \OpenApi\Attributes\Response(
            response: 200,
            description: 'Get books by category ID',
            content: new Model(type: BookListResponse::class)
        ),
        \OpenApi\Attributes\Response(
            response: 404,
            description: "book category didn't find",
            content: new Model(type: ErrorResponse::class)
        )]
    #[Route(
        path: '/api/v1/category/{id}/books',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function bookByCategory(int $id): Response
    {
        return $this->json($this->bookService->getBookByCategory($id));
    }
}
