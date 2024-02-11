<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\BookListResponse;
use App\Service\BookService;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    /**
     * @param BookService $bookService
     */
    public function __construct(private readonly BookService $bookService)
    {
    }

    #[\OpenApi\Attributes\Response(
        response: 200,
        description: 'Get books by category ID',
        content: new Model(type: BookListResponse::class)
    )]
    #[Route(path: '/api/v1/category/{id}/books', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function bookByCategory(int $id): Response
    {
        try {
            return $this->json($this->bookService->getBookByCategory($id));
        } catch (Exception $exception) {
            dd($exception->getMessage());
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }
}
