<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BookCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookCategoryFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager): void
    {
        $product = new BookCategory();
        $manager->persist($product->setTitle('Android')->setSlug('android'));
        $manager->persist($product->setTitle('Iphone')->setSlug('ios'));

        $manager->flush();
    }
}
