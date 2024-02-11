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
        $product = new BookCategory();
        $categories = [
            self::ANDROID => $product->setTitle('Android')->setSlug('android'),
            self::IPHONE => $product->setTitle('Iphone')->setSlug('ios'),
            self::WINDOWS_PHONE => $product->setTitle('Windows')->setSlug('windows_mobile'),
        ];

        foreach ($categories as $category) {
            $manager->persist($category);
        }
        $manager->flush();

        foreach ($categories as $key => $category) {
            $this->addReference($key, $category);
        }
        $manager->flush();
    }
}
