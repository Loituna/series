<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Container8Rx2Qs4\getSerieRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
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
    public function pdt(EntityManagerInterface $entityManager, SerieRepository $serieRepository): Response
    {

        $username = "<i><b>Irwin</b></i>";
        $serie = ["title" => "The Witcher", "year"=>2019, "acteur" => "THE CHAD BG CAVILL XoXoLove<3<3<3<3"];

        $serie2 = new Serie();

        $serie2
            ->setBackdrop("backdrop.png")
            ->setDateCreated(new \DateTime())
            ->setGenres('drama')
            ->setName('utopia')
            ->setFirstAirDate(new \DateTime("-2 year"))
            ->setLastAirDate(new \DateTime("-2 month"))
            ->setPopularity(500)
            ->setPoster("poster.png")
            ->setStatus("canceled")
            ->setTmdbId(123456)
            ->setVote(5);

                dump($serie2);

                // ancienne methode de persistence, crée la requete, puis vide la liste en l'exécutant
//                    $entityManager->persist($serie2);
//                    $entityManager->flush();
//                    dump($serie2);
//
//                    // si j'ai un ID j'update
//                    $serie2->setName("Pokemon");
//                    $entityManager->persist($serie2);
//                    $entityManager->flush();
//                    dump($serie2);
//
//                    // je supprime
//                    $entityManager->remove($serie2);
//                    $entityManager->flush();


        // Methode actuelle de persistence
//        $serieRepository->save($serie2, true);


        return $this->render('main/pdt.html.twig',[
            "pseudo" => $username,
            "serie"=> $serie,]);

// return $this->render('main/pdt.html.twig')



}



}
