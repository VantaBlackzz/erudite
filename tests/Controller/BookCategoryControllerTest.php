<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class BookCategoryControllerTest extends AbstractControllerTest
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function testGetCategories()
    {
        $this->em->persist((new BookCategory())->setTitle('Frontend')->setSlug('frontend'));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/book/categories');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

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
                            'required' => ['id', 'title', 'slug'],
                            'properties' => [
                                'title' => ['type' => 'string'],
                                'slug' => ['type' => 'string'],
                                'id' => ['type' => 'integer'],
                            ],
                        ],
                    ],
                ],
            ]
        );
    }
}
