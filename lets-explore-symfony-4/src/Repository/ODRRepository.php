<?php

namespace App\Repository;

use App\Entity\ODR;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ODR|null find($id, $lockMode = null, $lockVersion = null)
 * @method ODR|null findOneBy(array $criteria, array $orderBy = null)
 * @method ODR[]    findAll()
 * @method ODR[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ODRRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ODR::class);
    }

    /**
     * @return ODR[] Returns an array of ODR objects
     */

    public function countMinorAndMajorBehaviorsById()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT(minMaj.id) as id, count(minMaj.id) AS countODR, minMaj.name
          FROM \App\Entity\ODR odr 
          JOIN odr.minorAndMajorBehaviors minMaj
          GROUP BY minMaj.id  
          HAVING countODR >= 1'
        );

// returns an array of Product objects
        return $query->execute();
    }


    /*
    public function findOneBySomeField($value): ?ODR
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
