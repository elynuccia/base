<?php

namespace App\Repository;

use App\Entity\MinorAndMajorBehavior;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MinorAndMajorBehavior|null find($id, $lockMode = null, $lockVersion = null)
 * @method MinorAndMajorBehavior|null findOneBy(array $criteria, array $orderBy = null)
 * @method MinorAndMajorBehavior[]    findAll()
 * @method MinorAndMajorBehavior[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MinorAndMajorBehaviorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MinorAndMajorBehavior::class);
    }

//    /**
//     * @return MinorAndMajorBehavior[] Returns an array of MinorAndMajorBehavior objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MinorAndMajorBehavior
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
