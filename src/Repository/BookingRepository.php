<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    // /**
    //  * @return Booking[] Returns an array of Booking objects
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
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function sumQuantity($date)
    {

       //SELECT sum(quantite) FROM `booking` WHERE date_created = "2020-01-20"
      /* $dql = "SELECT SUM(e.amount) AS balance FROM Bank\Entities\Entry e " .
      "WHERE e.account = ?1";

       $balance = $em->createQuery($dql)
             ->setParameter(1, $myAccountId)
             ->getSingleScalarResult(); */

       return $this->createQueryBuilder('b')
           ->where('b.jour_de_visite = :date')
           ->setParameter('date', $date)
           ->select('sum(b.quantite) as totalbillets ')
           ->getQuery()
           ->getSingleScalarResult()
       ;
   }
}
