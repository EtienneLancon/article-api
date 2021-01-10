<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;

use App\Entity\Root;

class RootController extends AbstractController
{
    /**
     * @Get(path="/",
     *      name="root")
     * @View(statusCode="200")
     */
    public function root()
    {
        return new Root();
    }
}
