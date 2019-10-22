<?php

namespace App\Repository;

use App\Entity\ScreeningToolData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScreeningToolData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScreeningToolData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScreeningToolData[]    findAll()
 * @method ScreeningToolData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScreeningToolDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScreeningToolData::class);
    }

//    /**
//     * @return ScreeningToolData[] Returns an array of ScreeningToolData objects
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
    public function countValueByExpectation($schoolCode)
    {
        $entityManager = $this->getEntityManager();
//query che restituisce per ogni aspettativa il count dei singoli value
        $query = $entityManager->createQuery(/** @lang text */
            'SELECT DISTINCT (exp.id) as id, std.value, count(std.value) as count, exp.name
                    FROM \App\Entity\ScreeningToolData std
                    JOIN std.expectation exp
                    JOIN exp.matrix mat
                    JOIN mat.school sch
                    WHERE sch.schoolCode = :schoolCode
                    GROUP BY exp.id, std.value, exp.name'
        )->setParameter('schoolCode', $schoolCode);;

// returns an array of Product objects
        $results = $query->execute();

        $groupedResults = array();
//array associativo raggruppato per name dell'aspettativa
        foreach($results as $key => $result) {
            $groupedResults[$result['name']][] = array(
                'value' => $result['value'],
                'count' => $result['count']
            );
        }
//controlla se è presente il value da 1 a 5 se non c'è mette uno 0
        foreach($groupedResults as $key => &$result) {
            for($i=1; $i<=5; $i++) {
                if($this->hasValue($result, $i) == false) {
                    $groupedResults[$key][] = array(
                        'value' => $i,
                        'count' => 0
                    );
                }
            }
//ordina l'array
            uasort($result, function($a, $b){
                if($a['value'] == $b['value']) {
                    return 0;
                }

                return ($a['value'] < $b['value']) ? -1 : 1;
            });
        }

        return $groupedResults;
    }

    /*
    public function findOneBySomeField($value): ?ScreeningToolData
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
//controlla se value è presente in grouped values
    public function hasValue($groupedValues, $value)
    {
        foreach($groupedValues as $groupedValue) {
            if($groupedValue['value'] == $value) {
                return true;
            }
        }

        return false;
    }
}
