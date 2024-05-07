<?php

namespace App\Repository;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hotel>
 *
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    public function findAllHotelNames(): array
    {
        $hotels = $this->findAll();
        $hotelNames = [];

        foreach ($hotels as $hotel) {
            $hotelNames[] = $hotel->getNomHotel();
        }

        return $hotelNames;
    }

    public function findBySearchQuery(?string $query): array
    {
        if (!$query) {
            return $this->findAll();
        }

        return $this->createQueryBuilder('h')
            ->andWhere('h.idHotel LIKE :query OR h.nomHotel LIKE :query OR h.adressHotel LIKE :query OR h.prix1 LIKE :query OR h.prix2 LIKE :query OR h.prix3 LIKE :query OR h.numero1 LIKE :query OR h.numero2 LIKE :query OR h.numero3 LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }


      public function findAllAscending(string $criteria): array
    {
        return $this->createQueryBuilder('h')
            ->orderBy($criteria, 'ASC') // Replace 'fieldToSortBy' with the actual field name you want to sort by
            ->getQuery()
            ->getResult();
    }

    public function findAllDescending(string $criteria): array
    {
        return $this->createQueryBuilder('h')
            ->orderBy($criteria, 'DESC') // Replace 'fieldToSortBy' with the actual field name you want to sort by
            ->getQuery()
            ->getResult();
    }

    
    public function findAllSorted(): array
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->orderBy('h.prix1', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
    public function findAllSorted1(): array
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->orderBy('h.prix1', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }


    public function advancedSearch($query, $idHotel, $nomHotel, $adressHotel)
    {
        $qb = $this->createQueryBuilder('c');

        if ($query) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('c.idHotel', ':query'),
                $qb->expr()->like('c.nomHotel', ':query'),
                $qb->expr()->like('c.adressHotel', ':query'),

            ))
                ->setParameter('query', '%' . $query . '%');
        }

        if ($idHotel) {
            $qb->andWhere('c.idHotel = :idHotel')
                ->setParameter('idHotel', $idHotel);
        }

        if ($nomHotel) {
            $qb->andWhere('c.nomHotel = :nomHotel')
                ->setParameter('nomHotel', $nomHotel);
        }

        if ($adressHotel) {
            $qb->andWhere('c.adressHotel = :adressHotel')
                ->setParameter('adressHotel', $adressHotel);
        }

        return $qb->getQuery()->getResult();
    }




   




   

//    /**
//     * @return Hotel[] Returns an array of Hotel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hotel
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
