<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use App\Entity\Entity;
use App\InputHandler\Valider;

abstract class MyAbstractController extends AbstractFOSRestController
{
    public function update(Entity $item, int $id, ConstraintViolationList $violations): Entity
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(get_class($item));

        Valider::throwOnViolation($violations);
        $dbitem = Valider::returnFoundOrThrow($repo, $id);
        
        foreach($item->getOwnParams() as $paramName){
            if($paramName != 'id'){
                $name = ucfirst($paramName);
                $set = "set".$name;
                $get = "get".$name;
                if(!is_null($item->$get())){
                    $dbitem->$set($item->$get());
                }
            }
        }

        $em->flush();

        return $dbitem;
    }

    public function delete(string $class, int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $item = Valider::returnFoundOrThrow($em->getRepository($class), $id);

        $em->remove($item);
        $em->flush();

        return ['info' => 'deleted']; //anyway will return 204, but symfony wants something
    }

    public function create(Entity $item, ConstraintViolationList $violations): Entity
    {
        Valider::throwOnViolation($violations);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        return $item;
    }

    public function list(string $class, $sqlparams = array(), $limit = 10, $page = 1, $order = "asc")
    {
        $route = $this->getCurrentRouteName();
        $routeParams = $this->getCurrentRouteParams();
        
        $em = $this->getDoctrine()->getManager();
        $pager = $em->getRepository($class)
                    ->search($route, $sqlparams, $order, $limit, $page, $routeParams);

        return $pager;
    }

    public function getCurrentRouteName()
    {
        return $this->container->get('request_stack')
                                ->getCurrentRequest()
                                ->attributes->get('_route');
    }

    public function getCurrentRouteParams()
    {
        return $this->container->get('request_stack')
                                ->getCurrentRequest()
                                ->attributes->get('_route_params');
    }
}