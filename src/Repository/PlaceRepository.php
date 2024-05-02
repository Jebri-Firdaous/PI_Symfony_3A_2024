<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Place>
 *
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    /**
     * @return Place[] Returns an array of Place objects
     */
    public function findByIdPark($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.idParking = :val')
            ->setParameter('val', $value)
         //    ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIdClient($value): ?Place
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id_personne = :val')
            ->setParameter('val', $value)
         //    ->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function tri($crit){
        $em = $this->getEntityManager();
        return $em->createQuery('SELECT p FROM App\Entity\Place p ORDER BY p.'.$crit)
        ->getResult();
    }

//    public function findOneBySomeField($value): ?Place
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
