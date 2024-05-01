<?php

namespace App\Repository;

use App\Entity\Billet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Billet>
 *
 * @method Billet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billet[]    findAll()
 * @method Billet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class billetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billet::class);
    }

//    /**
//     * @return Billet[] Returns an array of Billet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Billet
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function getDestinationsByStation()
{
    return $this->createQueryBuilder('b')
        ->select('s.nomStation as nomstation, s.adressStation as adresse, s.type as type, COUNT(b) as count')
        ->leftJoin('b.station', 's')
        ->groupBy('s.nomStation, s.adressStation, s.type') // Regroupement par nomStation, adresseStation et type
        ->getQuery()
        ->getResult();
}


public function getPricesByStation()
{
    return $this->createQueryBuilder('b')
        ->select('s.nomStation as nom, s.adressStation as adresse, s.type as type, SUM(b.prix) as totalPrice')
        ->leftJoin('b.station', 's')
        ->groupBy('s.nomStation, s.adressStation, s.type') // Regroupement par nom de la station, adresse et type
        ->getQuery()
        ->getResult();
}

    
}