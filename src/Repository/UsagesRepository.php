<?php

namespace App\Repository;

use App\Entity\Usages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Usages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usages[]    findAll()
 * @method Usages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsagesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usages::class);
    }

    // /**
    //  * @return Usages[] Returns an array of Usages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usages
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
