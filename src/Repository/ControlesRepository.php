<?php

namespace App\Repository;

use App\Entity\Controles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Controles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Controles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Controles[]    findAll()
 * @method Controles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControlesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Controles::class);
    }

    public function getDays(\DateTime $firstDateTime, \DateTime $lastDateTime)
    {
        $qb = $this->createQueryBuilder("c")
            ->where('c.CreatedAt BETWEEN :firstDate AND :lastDate')
            ->setParameter('firstDate', $firstDateTime)
            ->setParameter('lastDate', $lastDateTime)
        ;

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * @return Controles[] Returns an array of Controles objects
     */    
    public function findHebdoDate($value1, $value2)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.CreatedAt = :val')
            ->setParameter('val', $value1)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Controles[] Returns an array of Controles objects
     */    
    public function findInfo($value1)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Immatriculation LIKE :val')
            ->setParameter('val', $value1)
            ->orderBy('c.id', 'DESC')
            ->groupBy('c.Immatriculation')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    // /**
    //  * @return Controles[] Returns an array of Controles objects
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
    public function findOneBySomeField($value): ?Controles
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
