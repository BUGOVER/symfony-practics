<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Book;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $book = new Book();

        $android_category = $this->getReference(BookCategoryFixtures::ANDROID);
        $iphone_category = $this->getReference(BookCategoryFixtures::IPHONE);
        $windows_category = $this->getReference(BookCategoryFixtures::WINDOWS_PHONE);

        $book
            ->setTitle('Samsung')
            ->setDate(new DateTime('2024-04-01'))
            ->setSlug('samsung-android-evolution')
            ->setMeap(true)
            ->setImage('')
            ->setAuthors(['Bryan Nantre'])
            ->setCategories(new ArrayCollection([$android_category, $iphone_category, $windows_category]));

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
