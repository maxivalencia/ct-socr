<?php

namespace App\Repository;

use App\Entity\BundleControles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BundleControles|null find($id, $lockMode = null, $lockVersion = null)
 * @method BundleControles|null findOneBy(array $criteria, array $orderBy = null)
 * @method BundleControles[]    findAll()
 * @method BundleControles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BundleControlesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BundleControles::class);
    }

    // /**
    //  * @return BundleControles[] Returns an array of BundleControles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BundleControles
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
