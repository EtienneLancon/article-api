<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }
    //"SELECT a FROM App\Entity\Author a WHERE a.fullname LIKE ?1 ORDER BY a.fullname asc"
    //SELECT a0_.id AS id_0, a0_.fullname AS fullname_1, a0_.biography AS biography_2 
    //FROM author a0_ ORDER BY a0_.fullname ASC
    //SELECT a0_.id AS id_0, a0_.fullname AS fullname_1, a0_.biography AS biography_2 
    //FROM author a0_ WHERE a0_.fullname LIKE ? ORDER BY a0_.fullname ASC

    //SELECT a0_.id AS id_0, a0_.title AS title_1, a0_.content AS content_2, a0_.short_description AS short_description_3, 
    //a0_.author_id AS author_id_4 FROM article a0_ WHERE a0_.title LIKE ? ORDER BY a0_.title ASC

    public function search($route, $params = array(), $order = 'asc', $limit = 20, $page = 0, $routeParams = array())
    {
        $qb = $this
            ->createQueryBuilder('qb')
            ->select('qb')
            ->orderBy('qb.fullname', $order)
        ;
        
        $qb = $this->setQueryBuilderParams($qb, $params);
        
        return $this->paginate($qb, $route, $limit, $page, $routeParams);
    }

    // /**
    //  * @return Author[] Returns an array of Author objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
