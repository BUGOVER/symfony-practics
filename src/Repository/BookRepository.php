<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param int $categoryId
     * @return Book[]
     */
    public function findBooksByCategoryId(int $categoryId): mixed
    {
        $dql = 'SELECT b FROM App\Entity\Book b WHERE :categoryId MEMBER OF b.categories AND b.date IS NOT NULL';

        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter('categoryId', $categoryId)
            ->getResult();
    }
}
