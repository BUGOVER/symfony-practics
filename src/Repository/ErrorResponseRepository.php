<?php

namespace App\Repository;

use App\Entity\ErrorResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ErrorResponse>
 *
 * @method ErrorResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ErrorResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ErrorResponse[]    findAll()
 * @method ErrorResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErrorResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ErrorResponse::class);
    }

//    /**
//     * @return ErrorResponse[] Returns an array of ErrorResponse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ErrorResponse
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
