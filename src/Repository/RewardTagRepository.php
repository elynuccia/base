<?php

namespace App\Repository;

use App\Entity\RewardTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RewardTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method RewardTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method RewardTag[]    findAll()
 * @method RewardTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardTagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RewardTag::class);
    }

//    /**
//     * @return RewardTag[] Returns an array of RewardTag objects
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
    public function findOneBySomeField($value): ?RewardTag
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
