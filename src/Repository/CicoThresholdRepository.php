<?php

namespace App\Repository;

use App\Entity\CicoThreshold;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CicoThreshold|null find($id, $lockMode = null, $lockVersion = null)
 * @method CicoThreshold|null findOneBy(array $criteria, array $orderBy = null)
 * @method CicoThreshold[]    findAll()
 * @method CicoThreshold[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CicoThresholdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CicoThreshold::class);
    }

//    /**
//     * @return CicoThreshold[] Returns an array of CicoThreshold objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CicoThreshold
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
