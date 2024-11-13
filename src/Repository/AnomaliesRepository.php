<?php

namespace App\Repository;

use App\Entity\Anomalies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Anomalies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anomalies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anomalies[]    findAll()
 * @method Anomalies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnomaliesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Anomalies::class);
    }

    /* public function countAnomalieRepetition($value):array
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.code_anomalie, count(c.id)')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    } */
   

    // /**
    //  * @return Anomalies[] Returns an array of Anomalies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Anomalies
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
