<?php

namespace App\Repository;

use App\Entity\POR;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method POR|null find($id, $lockMode = null, $lockVersion = null)
 * @method POR|null findOneBy(array $criteria, array $orderBy = null)
 * @method POR[]    findAll()
 * @method POR[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PORRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, POR::class);
    }

    public function countPositiveBehaviorsById()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT(posBehavior.id) as id, count(posBehavior.id) AS countPOR, posBehavior.behavior
          FROM \App\Entity\POR por 
          JOIN por.positiveBehaviors posBehavior
          GROUP BY posBehavior.id  
          HAVING countPOR >= 1'
        );

// returns an array of Product objects
        return $query->execute();
    }

    /*
    public function findOneBySomeField($value): ?POR
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
