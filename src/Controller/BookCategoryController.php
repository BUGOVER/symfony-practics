<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\BookCategoryListResponse;
use App\Service\BookCategoryService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookCategoryController extends AbstractController
{
    /**
     * @param BookCategoryService $bookCategoryService
     */
    public function __construct(private readonly BookCategoryService $bookCategoryService)
    {
    }

    #[\OpenApi\Attributes\Response(
        response: 200,
        description: 'Get all categories ordered by ASC',
        content: new Model(type: BookCategoryListResponse::class)
    )]
    #[Route(path: '/api/v1/categories', methods: ['GET'])]
    public function categories(): Response
    {
        return $this->json($this->bookCategoryService->getCategories());
    }
}
