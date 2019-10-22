<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Student::class);
    }


    public function findStudentsByTeacherCoordinator( $teacherCoordinator)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT(stud.id) as id, stud.teacherCoordinator, stud.code
          FROM \App\Entity\Student stud 
          WHERE stud.teacherCoordinator = :teacherCoordinator
          GROUP BY stud.id, stud.teacherCoordinator, stud.code  '
        )->setParameter('teacherCoordinator', $teacherCoordinator);

        // returns an array of Product objects
        return $query->execute();
    }

    public function findStudentsBySchoolCode( $schoolCode)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT stud
          FROM \App\Entity\Student stud 
          JOIN stud.personInCharge personInCharge
          WHERE stud.schoolCode = :schoolCode
          GROUP BY stud.id, stud.nickname, stud.code, stud.qrCode  '
        )->setParameter('schoolCode', $schoolCode);

        // returns an array of Product objects
        return $query->execute();
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
