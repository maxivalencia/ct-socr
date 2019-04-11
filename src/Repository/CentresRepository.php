<?php

namespace App\Repository;

use App\Entity\Centres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Centres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Centres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Centres[]    findAll()
 * @method Centres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentresRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Centres::class);
    }

    // /**
    //  * @return Centres[] Returns an array of Centres objects
    //  */
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
    public function findOneBySomeField($value): ?Centres
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
