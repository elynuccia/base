<?php

namespace App\Repository;


use App\Entity\Matrix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Matrix|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matrix|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matrix[]    findAll()
 * @method Matrix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatrixRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Matrix::class);
    }

    public function findMBySchoolCode($schoolCode)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT(m.id) as id, m.motto as motto
          FROM \App\Entity\Matrix m 
          JOIN m.school school
          WHERE school.schoolCode = :schoolCode
          GROUP BY m.motto, m.id '
        )->setParameter('schoolCode', $schoolCode);


// returns an array of Product objects
        return $query->execute();

    }

//    /**
//     * @return MatrixBehavior[] Returns an array of MatrixBehavior objects
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
    public function findOneBySomeField($value): ?MatrixBehavior
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
