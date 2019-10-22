<?php

namespace App\Repository;

use App\Entity\StudentBehave;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StudentBehave|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentBehave|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentBehave[]    findAll()
 * @method StudentBehave[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentBehaveRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentBehave::class);
    }

    public function countStudentsByUserId($userId)
    {
        return $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->andWhere('s.creatorUserId = :creatorUserId')
            ->setParameter('creatorUserId', $userId)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
    public function findByCreatorUserIdOrderedByNameAsc($userId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.creatorUserId = :creatorUserId')
            ->setParameter('creatorUserId', $userId)
            ->orderBy('s.studentId', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
//    /**
//     * @return Student[] Returns an array of Student objects
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
    public function findOneBySomeField($value): ?Student
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
