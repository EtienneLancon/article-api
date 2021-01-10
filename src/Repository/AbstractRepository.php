<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Configuration\Route;
use Hateoas\Representation\CollectionRepresentation;

abstract class AbstractRepository extends ServiceEntityRepository implements RepositoryInterface
{
    protected function paginate(QueryBuilder $qb, $route, $limit = 20, $page = 0, $routeParams = array())
    {
        if (0 == $limit || 0 == $page) {
            throw new \LogicException('$limit & $offstet must be greater than 0.');
        }
        
        if(empty($route)){
            throw new \LogicException('$route cannot be empty.');
        }

        if(empty($qb)){
            throw new \LogicException('Query cannot be empty.');
        }
        
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setMaxPerPage((int) $limit);
        $pager->setCurrentPage($page);

        $pagerfantaFactory   = new PagerfantaFactory(); // you can pass the page and limit parameters name
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
            $pager,
            new Route($route, $routeParams, true),
            new CollectionRepresentation($pager->getCurrentPageResults())
        );
        
        return $paginatedCollection;
    }
    
    protected function setQueryBuilderParams($qb, $params)
    {
        $paramNumber = 0;
        
        foreach($params as $name => $value){
            $paramNumber++;

            if(is_array($value)){
                if(!$value['strict']){
                    if(is_null($value['string'])) $value['string'] = '';
                    $qb->where('qb.'.$name.' like ?'.$paramNumber)
                        ->setParameter($paramNumber, '%'.$value['string'].'%');
                }else{
                    $qb->where('qb.'.$name.' = ?'.$paramNumber)
                        ->setParameter($paramNumber, $value['string']);
                }
            }else{
                $qb->where('qb.'.$name.' = ?'.$paramNumber)
                    ->setParameter($paramNumber, $value);
            }
        }

        return $qb;
    }
}