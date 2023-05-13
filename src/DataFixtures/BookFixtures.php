<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $frontendCategory = $this->getReference(BookCategoryFixtures::FRONTEND_CATEGORY);
        $backendCategory = $this->getReference(BookCategoryFixtures::BACKEND_CATEGORY);

        $book = (new Book())
            ->setTitle('Easy-peasy JS')
            ->setPublicationDate(new \DateTimeImmutable('2015-10-01'))
            ->setMeap(false)
            ->setAuthors(['Torsten Stock'])
            ->setSlug('easy-peasy-js')
            ->setCategories(new ArrayCollection([$frontendCategory, $backendCategory]))
            ->setImage('https://media.proglib.io/posts/2020/03/01/8a2f3a927258b1ae95c883de5ac39809.jpg')
            ->setIsbn('123321')
            ->setDescription('test description');

        $manager->persist($book);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BookCategoryFixtures::class,
        ];
    }
}
