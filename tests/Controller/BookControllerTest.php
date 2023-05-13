<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;

class BookControllerTest extends AbstractControllerTest
{
    /**
     * @throws ORMException
     */
    public function testBooksByCategory(): void
    {
        $categoryId = $this->createCategory();

        $this->client->request('GET', '/api/v1/category/'.$categoryId.'/books');
        $responseContent = json_decode(
            json: $this->client->getResponse()->getContent(),
            associative: true
        );

        $this->assertResponseIsSuccessful();

        $this->assertJsonDocumentMatchesSchema(
            jsonDocument: $responseContent,
            schema: [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'title', 'slug', 'image', 'authors', 'publicationDate'],
                        'properties' => [
                            'title' => ['type' => 'string'],
                            'slug' => ['type' => 'string'],
                            'id' => ['type' => 'integer'],
                            'publicationDate' => ['type' => 'integer'],
                            'image' => ['type' => 'string'],
                            'authors' => [
                                'type' => 'array',
                                'items' => ['type' => 'string'],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @throws ORMException
     */
    private function createCategory(): int
    {
        $bookCategory = (new BookCategory())->setTitle('Backend')->setSlug('backend');

        $this->em->persist($bookCategory);

        $this->em->persist((new Book())
            ->setTitle('test book')
            ->setImage('http://image.png')
            ->setMeap(false)
            ->setPublicationDate(new \DateTimeImmutable())
            ->setAuthors(['test author'])
            ->setIsbn('123')
            ->setDescription('description')
            ->setCategories(new ArrayCollection([$bookCategory]))
            ->setSlug('test-book')
        );

        $this->em->flush();

        return $bookCategory->getId();
    }
}
