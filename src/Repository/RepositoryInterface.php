<?php

namespace App\Repository;

interface RepositoryInterface
{
    public function search($route, $searchParams, $order, $limit, $page, $routeParams);
}