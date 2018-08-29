<?php

namespace App\Repository;

use App\Entity\Cico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cico|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cico|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cico[]    findAll()
 * @method Cico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CicoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cico::class);
    }

//    /**
//     * @return Cico[] Returns an array of Cico objects
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
    public function findOneBySomeField($value): ?Cico
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
