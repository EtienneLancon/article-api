<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MagazineController extends AbstractController
{
    /**
     * @Route("/magazine", name="magazine")
     */
    public function index(): Response
    {
        return $this->render('magazine/index.html.twig', [
            'controller_name' => 'MagazineController',
        ]);
    }
}
