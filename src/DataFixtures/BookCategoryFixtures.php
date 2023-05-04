<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BookCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookCategoryFixtures extends Fixture
{
    public const FRONTEND_CATEGORY = 'FrontendFix';

    public const BACKEND_CATEGORY = 'BackendFix';

    public const MOBILE_CATEGORY = 'MobileFix';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            self::FRONTEND_CATEGORY => (new BookCategory())->setTitle('FrontendFix')->setSlug('frontend'),
            self::BACKEND_CATEGORY => (new BookCategory())->setTitle('BackendFix')->setSlug('backend'),
        ];

        foreach ($categories as $category) {
            $manager->persist($category);
        }

        $manager->persist((new BookCategory())->setTitle('MobileFix')->setSlug('mobile'));

        $manager->flush();

        foreach ($categories as $code => $category) {
            $this->addReference($code, $category);
        }
    }
}
