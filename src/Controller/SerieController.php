<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('/{page}', name: 'list',requirements:["page"=> "\d+"])]
    public function list(SerieRepository $serieRepository,int $page = 1): Response
    { //tableau vide en premier parametre pour orderby = null

          //$series=$serieRepository->findBestSeries();
//        //$series=$serieRepository->findBy([],["popularity"=>'DESC'], limit:50);

//    if (!$series){
//        throw $this->createNotFoundException("ENCLUME KESTUFAI");//
//    }

        $nbSeries = $serieRepository->count([]);
        $maxPage = ceil($nbSeries/SerieRepository::MAX_RESULT);

        // Gestion des enclumes
        // Gestion page 1
        if($page<1){
            return $this->redirectToRoute('serie_list',['page'=>1]);
        }
        elseif($page>$maxPage){
            return $this->redirectToRoute('serie_list',['page'=>$maxPage]);

        }else{
            $series=$serieRepository->findSerieWithPagination($page);
            return $this->render('serie/list.html.twig', ['series'=> $series, 'currentPage' => $page , 'maxPage'=> $maxPage

        ]);}
    }

    #[Route('detail/{id}', name: 'show', requirements: ["id"=>"\d+"])]
    public function show(int $id,SerieRepository $serieRepository): Response
    {
       $serie=$serieRepository->find($id);

       if(!$serie){
        // permet de lancer une erreur 404
           throw $this->createNotFoundException("OOPS , serie not found");
       }

        return $this->render('serie/show.html.twig', ['serie'=> $serie
        ]);
    }


    #[Route('/add', name: 'add')]
    public function add(Request $request, SerieRepository $serieRepository): Response
    {

            //Creation d'instance de l'entité serie
            $serie = new Serie();
            //Instanciation du formulaire en lui passant l'instance de série
            $serieForm = $this->createForm(SerieType::class,$serie);


            //Permet d'extraire les données de la requete
            $serieForm->handleRequest($request);

            if($serieForm->isSubmitted() && $serieForm->isValid()) {
                //traitement de la données
                //récuperation des champs non mapped
                $genres=$serieForm->get('genres')->getData();
                $serie->setGenres(implode('/',$genres));
                // ajout de la date de creation de l'enregistrement
                $serie->setDateCreated((new \DateTime()));

                // enregistre la serie en bdd
                $serieRepository->save($serie,true);
                // Ajout d'un message de validation
                $this->addFlash('succes','Serie added');
                return $this->render('serie/show.html.twig', ['id'=> $serie->getId()]);
            }


        return $this->render('serie/add.html.twig', ["serieForm"=>$serieForm->createView()

        ]);
    }
    #[Route('/update/{id}', name: 'update', requirements: ["id"=>"\d+"])]
    public function update(int $id, SerieRepository $serieRepository ){
      $serie = $serieRepository->find($id);
      $serieForm = $this->createForm(SerieType::class,$serie);


      return $this->render('serie/update.html.twig',[
          'serieForm'=> $serieForm->createView()      ]);

    }





}
