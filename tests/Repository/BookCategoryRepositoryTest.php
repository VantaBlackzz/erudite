<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\BookCategory;
use App\Repository\BookCategoryRepository;
use App\Tests\AbstractRepositoryTest;

class BookCategoryRepositoryTest extends AbstractRepositoryTest
{
    private BookCategoryRepository $bookCategoryRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookCategoryRepository = $this->getRepositoryForEntity(BookCategory::class);
    }

    public function testFindAllSortedByTitle()
    {
        $backend = (new BookCategory())->setTitle('Backend')->setSlug('backend');
        $frontend = (new BookCategory())->setTitle('Frontend')->setSlug('frontend');
        $mobile = (new BookCategory())->setTitle('Mobile')->setSlug('mobile');

        foreach ([$backend, $frontend, $mobile] as $category) {
            $this->em->persist($category);
        }

        $this->em->flush();

        $titles = array_map(
            callback: fn (BookCategory $bookCategory) => $bookCategory->getTitle(),
            array: $this->bookCategoryRepository->findAllSortedByTitle()
        );

        $this->assertEquals(
            expected: ['Backend', 'Frontend', 'Mobile'],
            actual: $titles
        );
    }
}
