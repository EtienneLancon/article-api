<?php

namespace App\Repository;

use App\Entity\Root;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Root|null find($id, $lockMode = null, $lockVersion = null)
 * @method Root|null findOneBy(array $criteria, array $orderBy = null)
 * @method Root[]    findAll()
 * @method Root[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RootRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Root::class);
    }

    // /**
    //  * @return Root[] Returns an array of Root objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Root
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
