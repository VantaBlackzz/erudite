<?php

namespace App\DataFixtures;

use App\Entity\BookCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new BookCategory())->setTitle('FrontendFix')->setSlug('frontend'));
        $manager->persist((new BookCategory())->setTitle('BackendFix')->setSlug('backend'));
        $manager->persist((new BookCategory())->setTitle('MobileFix')->setSlug('mobile'));

        $manager->flush();
    }
}
