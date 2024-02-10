<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\BookService;
use Exception;
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

    /**
     * @throws HttpException
     */
    #[Route(path: '/api/v1/category/{id}/books', methods: ['GET'])]
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
