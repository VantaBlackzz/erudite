<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\BookCategory;
use App\Model\BookCategoryListItem;
use App\Model\BookCategoryListResponse;
use App\Repository\BookCategoryRepository;

class BookCategoryService
{
    public function __construct(private readonly BookCategoryRepository $bookCategoryRepository)
    {
    }

    public function getCategories(): BookCategoryListResponse
    {
        $categories = $this->bookCategoryRepository->findAllSortedByTitle();

        $items = array_map(
            callback: fn (BookCategory $bookCategory) => new BookCategoryListItem(
                id: $bookCategory->getId(),
                title: $bookCategory->getTitle(),
                slug: $bookCategory->getSlug()
            ),
            array: $categories
        );

        return new BookCategoryListResponse($items);
    }
}
