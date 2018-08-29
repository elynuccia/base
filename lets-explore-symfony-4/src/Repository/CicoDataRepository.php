<?php

namespace App\Repository;

use App\Entity\CicoData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CicoData|null find($id, $lockMode = null, $lockVersion = null)
 * @method CicoData|null findOneBy(array $criteria, array $orderBy = null)
 * @method CicoData[]    findAll()
 * @method CicoData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CicoDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CicoData::class);
    }

//    /**
//     * @return CicoData[] Returns an array of CicoData objects
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
    public function findOneBySomeField($value): ?CicoData
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
