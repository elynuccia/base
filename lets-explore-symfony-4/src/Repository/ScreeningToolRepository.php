<?php

namespace App\Repository;

use App\Entity\ScreeningTool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScreeningTool|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScreeningTool|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScreeningTool[]    findAll()
 * @method ScreeningTool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScreeningToolRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScreeningTool::class);
    }


    public function findScreeningToolBySchoolCode($schoolCode)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT screen
          FROM \App\Entity\ScreeningTool screen 
          JOIN screen.student stud
          WHERE stud.schoolCode = :schoolCode
       '
        )->setParameter('schoolCode', $schoolCode);

// returns an array of Product objects
        return $query->execute();
    }

//    /**
//     * @return ScreeningTool[] Returns an array of ScreeningTool objects
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
    public function findOneBySomeField($value): ?ScreeningTool
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
