<?php

namespace App\Repository;

use App\Entity\POR;
use App\Entity\Student;
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

    public function countBestPORById()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT(posBehavior.id) as id, count(posBehavior.id) AS countPOR, posBehavior.behavior
          FROM \App\Entity\POR por 
          JOIN por.positiveBehaviors posBehavior
          GROUP BY posBehavior.id 
          HAVING countPOR >=1
          ORDER BY countPOR DESC
          '
        )->setMaxResults(3 );

// returns an array of Product objects
        return $query->execute();
    }

    public function countPORByStudent(Student $student)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT(posBehavior.id) as id, count(posBehavior.id) AS countPOR, posBehavior.behavior
          FROM \App\Entity\POR por 
          JOIN por.positiveBehaviors posBehavior
          WHERE por.student = :student
          GROUP BY posBehavior.id  
          HAVING countPOR >= 1'
        )->setParameter('student', $student);

// returns an array of Product objects
        return $query->execute();
    }

    public function countBestPORByStudent(Student $student)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT(posBehavior.id) as id, count(posBehavior.id) AS countPOR, posBehavior.behavior
          FROM \App\Entity\POR por 
          JOIN por.positiveBehaviors posBehavior
          WHERE por.student = :student
          GROUP BY posBehavior.id 
          HAVING countPOR >=1
          ORDER BY countPOR DESC'
        )->setParameter('student', $student)
            ->setMaxResults(3 );

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
