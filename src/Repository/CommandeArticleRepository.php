<?php

namespace App\Repository;

use App\Entity\CommandeArticle; 
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommandeArticle> // Mettre à jour le type d'entité
 *
 * @method CommandeArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeArticle[]    findAll()
 * @method CommandeArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeArticleRepository extends ServiceEntityRepository 
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeArticle::class); // Mettre à jour le type d'entité
    }


//    /**
//     * @return CommandeArticle[] Returns an array of CommandeArticle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CommandeArticle
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}

