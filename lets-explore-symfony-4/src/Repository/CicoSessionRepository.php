<?php

namespace App\Repository;

use App\Entity\CicoSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CicoSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method CicoSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method CicoSession[]    findAll()
 * @method CicoSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CicoSessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CicoSession::class);
    }

//    /**
//     * @return CicoSession[] Returns an array of CicoSession objects
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
    public function findOneBySomeField($value): ?CicoSession
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
