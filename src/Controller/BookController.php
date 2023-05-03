<?php

namespace App\Controller;

use App\Exception\BookCategoryNotFoundException;
use App\Model\BookListResponse;
use App\Service\BookService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    public function __construct(private readonly BookService $bookService)
    {
    }

    #[OA\Response(
        response: 200,
        description: 'Returns books by category',
        attachables: [new Model(type: BookListResponse::class)]
    )]
    #[OA\Tag(name: 'Books by category')]
    #[Route(path: 'api/v1/category/{id}/books', methods: ['GET'])]
    public function booksByCategory(int $id): Response
    {
        try {
            return $this->json($this->bookService->getBooksByCategory($id));
        } catch (BookCategoryNotFoundException $e) {
            throw new HttpException($e->getCode(), $e->getMessage());
        }
    }
}
