<?php

namespace App\Repository;

use App\Entity\Cico;
use App\Entity\Student;
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

    public function findByStudent(Student $student)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT cico.id as id, sessions.id as session, sessions.fillInDate, cico.threshold as threshold, sum(data.value) as sumDatas
          FROM \App\Entity\Cico cico
          JOIN cico.sessions sessions 
          JOIN sessions.data data
          WHERE cico.student = :student
          GROUP BY sessions.id
          ORDER BY cico.id DESC' //Sistema il piu recente
        )->setParameter('student', $student);

// returns an array of Product objects
        return $query->execute();
    }

    public function findCicoBySchoolCode( $schoolCode)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT cico
          FROM \App\Entity\Cico cico 
          JOIN cico.matrix mat
          JOIN mat.school school
          
          WHERE school.schoolCode = :schoolCode
         '
        )->setParameter('schoolCode', $schoolCode);

        // returns an array of Product objects
        return $query->execute();
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
