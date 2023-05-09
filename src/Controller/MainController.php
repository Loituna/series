<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_default')]
    public function default(): Response
    {
        die("Hello World !!!!");

    }
    // annotation interpretable
    /*
     * @Route("/Home",name="main_home2")
     */
    #[Route('/home', name: 'main_home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig');

    }

    #[Route('/pdt', name: 'main_pdt')]
    public function pdt(): Response
    {
        return $this->render('main/pdt.html.twig');


    }
}
