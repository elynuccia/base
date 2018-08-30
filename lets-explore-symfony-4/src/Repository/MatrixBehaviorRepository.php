<?php

namespace App\Repository;

use App\Entity\ExpectationTag;
use App\Entity\LocationTag;
use App\Entity\MatrixBehavior;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MatrixBehavior|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatrixBehavior|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatrixBehavior[]    findAll()
 * @method MatrixBehavior[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatrixBehaviorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MatrixBehavior::class);
    }

    public function findByExpectationAndLocation(ExpectationTag $expectationTag, LocationTag $locationTag)
    {
        return $this->createQueryBuilder('s')
            ->where('s.location = :location')
            ->andWhere('s.expectation = :expectation')
            ->setParameter('location', $locationTag)
            ->setParameter('expectation', $expectationTag)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return MatrixBehavior[] Returns an array of MatrixBehavior objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MatrixBehavior
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
