<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Repository\BookRepository;
use App\Tests\AbstractRepositoryTest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class BookRepositoryTest extends AbstractRepositoryTest
{
    private BookRepository $bookRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->getRepositoryForEntity(Book::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function testFindBooksByCategoryId()
    {
        $backendCategory = (new BookCategory())->setTitle('Backend')->setSlug('backend');
        $this->em->persist($backendCategory);

        for ($i = 0; $i < 5; ++$i) {
            $book = $this->createBook('backend-'.$i, $backendCategory);
            $this->em->persist($book);
        }

        $this->em->flush();

        $this->assertCount(
            expectedCount: 5,
            haystack: $this->bookRepository->findBooksByCategoryId($backendCategory->getId())
        );
    }

    private function createBook(string $title, BookCategory $bookCategory): Book
    {
        return (new Book())
            ->setPublicationDate(new \DateTimeImmutable())
            ->setAuthors(['test Author'])
            ->setMeap(false)
            ->setSlug($title)
            ->setDescription('description')
            ->setIsbn('123')
            ->setCategories(new ArrayCollection([$bookCategory]))
            ->setTitle($title)
            ->setImage('https://testlocalhost/'.$title.'.png');
    }
}
