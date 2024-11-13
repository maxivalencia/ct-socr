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

    public function countByDayLast30Days() : array
    {
        /* $today = date("Y-m-d");
        $qb = $this->createQueryBuilder("c")
            ->where('c.CreatedAt LIKE :daty')
            ->setParameter('daty', $today)
            ->orderBy('c.id', 'ASC')
        ; */
        //$today = date("Y-m-d");
        $today = new \DateTime('-30 days');
        $today = $today->format("Y-m-d");
        $qb = $this->createQueryBuilder('e')
            ->select("DATE(e.createdAt) as date, COUNT(e.id) as total")
            ->where("e.createdAt >= :daty")
            //->setParameter('daty', new \DateTime('-30 days'))
            ->setParameter('daty', $today)
            ->groupBy("date")
            ->orderBy("date", "ASC");

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function countForToday(): int
    {
        $today = date("Y-m-d");
        $qb = $this->createQueryBuilder('e')
            ->select("COUNT(e.id) as total")
            ->where("DATE(e.createdAt) = :today")
            //->setParameter('today', new \DateTime());
            ->setParameter('today', $today);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countPapierRecupererForToday(): int
    {
        $today = date("Y-m-d");
        $qb = $this->createQueryBuilder('e')
            ->select("COUNT(e.id) as total")
            ->where("DATE(e.createdAt) = :today AND e.papiers_retirers = :papier")
            //->setParameter('today', new \DateTime());
            ->setParameter('today', $today)
            ->setParameter('papier', 1);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countPapierRecuperer(): int
    {
        $today = date("Y-m-d");
        $qb = $this->createQueryBuilder('e')
            ->select("COUNT(e.id) as total")
            ->where("e.papiers_retirers = :papier")
            ->setParameter('papier', 1);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countMiseEnFourierreForToday(): int
    {
        $today = date("Y-m-d");
        $qb = $this->createQueryBuilder('e')
            ->select("COUNT(e.id) as total")
            ->where("DATE(e.createdAt) = :today AND e.mise_en_fourriere = :fourriere")
            //->setParameter('today', new \DateTime());
            ->setParameter('today', $today)
            ->setParameter('fourriere', 1);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countMiseEnFourierre(): int
    {
        $today = date("Y-m-d");
        $qb = $this->createQueryBuilder('e')
            ->select("COUNT(e.id) as total")
            ->where("e.mise_en_fourriere = :fourriere")
            ->setParameter('fourriere', 1);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countAnomalieRepetition($value):array
    {
        return $this->createQueryBuilder('c')
            ->select('a.code_anomalie, count(a.id) as total')
            ->join('c.anomalies_collections', 'a')
            ->groupBy('a.id')
            ->orderBy('total', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Controles[] Returns an array of Controles objects
     */
    public function getToday()
    {
        $today = date("Y-m-d");
        $qb = $this->createQueryBuilder("c")
            ->where('c.CreatedAt LIKE :daty')
            ->setParameter('daty', $today)
            ->orderBy('c.id', 'ASC')
        ;

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * @return Controles[] Returns an array of Controles objects
     */
    public function getAnotherDay(\DateTime $firstDateTime)
    {
        $today = $firstDateTime->format('Y-m-d');
        $qb = $this->createQueryBuilder("c")
            ->where('c.CreatedAt LIKE :daty')
            ->setParameter('daty', $today)
            ->orderBy('c.id', 'ASC')
        ;

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * @return Controles[] Returns an array of Controles objects
     */
    public function getDays(\DateTime $firstDateTime, \DateTime $lastDateTime)
    {
        $qb = $this->createQueryBuilder("c")
            ->where('c.CreatedAt BETWEEN :firstDate AND :lastDate')
            ->setParameter('firstDate', $firstDateTime)
            ->setParameter('lastDate', $lastDateTime)
            ->orderBy('c.id', 'ASC')
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
            //->setMaxResults(10)
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
            //->groupBy('c.Immatriculation')
            ->setMaxResults(1)
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
