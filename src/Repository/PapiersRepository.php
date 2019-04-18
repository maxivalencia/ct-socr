<?php

namespace App\Repository;

use App\Entity\Papiers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Papiers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Papiers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Papiers[]    findAll()
 * @method Papiers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PapiersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Papiers::class);
    }

    // /**
    //  * @return Papiers[] Returns an array of Papiers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Papiers
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
