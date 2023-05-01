<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookCategoryControllerTest extends WebTestCase
{
    public function testGetCategories()
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/book/categories');
        $responseContent = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();

        $this->assertJsonStringEqualsJsonFile(
            expectedFile: __DIR__.'/responses/BookCategoryControllerTest_testCategories.json',
            actualJson: $responseContent
        );
    }
}
