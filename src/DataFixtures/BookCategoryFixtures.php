<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BookCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookCategoryFixtures extends Fixture
{
    public const ANDROID = 'android';

    public const IPHONE = 'ios';

    public const WINDOWS_PHONE = 'windows_phone';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager): void
    {
        $book_category = new BookCategory();
        $categories = [
            self::ANDROID => $book_category->setTitle('Android')->setSlug(self::ANDROID),
            self::IPHONE => $book_category->setTitle('Iphone')->setSlug(self::IPHONE),
            self::WINDOWS_PHONE => $book_category->setTitle('Windows')->setSlug(self::WINDOWS_PHONE),
        ];

        foreach ($categories as $category) {
            $manager->persist($category);
        }
        $manager->flush();

        foreach ($categories as $name => $category) {
            $this->addReference($name, $category);
        }
    }
}
