<?php

namespace App\Repository;

use App\Entity\Utilisations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Utilisations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisations[]    findAll()
 * @method Utilisations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisationsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Utilisations::class);
    }

    // /**
    //  * @return Utilisations[] Returns an array of Utilisations objects
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
    public function findOneBySomeField($value): ?Utilisations
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
