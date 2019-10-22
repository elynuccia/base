<?php

namespace App\Repository;

use App\Entity\PersonInCharge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PersonInCharge|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonInCharge|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonInCharge[]    findAll()
 * @method PersonInCharge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonInChargeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PersonInCharge::class);
    }

//    /**
//     * @return PersonInCharge[] Returns an array of PersonInCharge objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonInCharge
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
