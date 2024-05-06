<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }


    public function getreservationStatistics()
    {
        return $this->createQueryBuilder('r')
            ->select('r.typeChambre, COUNT(r.refReservation) as count')
            ->groupBy('r.typeChambre')
            ->getQuery()
            ->getResult();
    }


    public function findAllSorted(): array
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->orderBy('r.prixReservation', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
    public function findAllSorted1(): array
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->orderBy('r.prixReservation', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }

    public function findBySearchQuery(?string $query): array
    {
        if (!$query) {
            return $this->findAll();
        }
    
        return $this->createQueryBuilder('r')
            ->leftJoin('r.idHotel', 'h')
            ->andWhere('r.refReservation LIKE :query OR r.dureeReservation LIKE :query OR r.prixReservation LIKE :query OR r.dateReservation LIKE :query OR r.typeChambre LIKE :query OR h.nomHotel LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Reservation[] Returns an array of Reservation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
