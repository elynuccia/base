<?php

namespace App\Repository;

use App\Entity\Rewards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rewards|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rewards|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rewards[]    findAll()
 * @method Rewards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rewards::class);
    }

    public function findDistinct()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT(rewards.name) as name, rewards.value as value, rewards.id as id
          FROM \App\Entity\Rewards rewards
          ORDER BY rewards.value ASC'
        );

// returns an array of Product objects
        return $query->execute();
    }

    public function findRewardsBySchoolCode($schoolCode)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT rewards
          FROM \App\Entity\Rewards rewards 
          JOIN rewards.school school
          WHERE school.schoolCode = :schoolCode
          '
        )->setParameter('schoolCode', $schoolCode);


// returns an array of Product objects
        return $query->execute();
    }

//    /**
//     * @return Rewards[] Returns an array of Rewards objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rewards
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
