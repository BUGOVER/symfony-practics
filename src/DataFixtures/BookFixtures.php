<?php

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

        $androidCategory = $this->getReference(BookCategoryFixtures::ANDROID);
        $iphoneCategory = $this->getReference(BookCategoryFixtures::IPHONE);
        $windowsCategory = $this->getReference(BookCategoryFixtures::WINDOWS_PHONE);

        $book
            ->setTitle('Samsung')
            ->setDate(new DateTime('2000-04-01'))
            ->setSlug('samsung-android-evolution')
            ->setMeap(true)
            ->setImage('')
            ->setAuthor('Bryan Nantre')
            ->setCategories(new ArrayCollection([$androidCategory]));
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
