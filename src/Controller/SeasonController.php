<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/season', name : 'season_')]
class SeasonController extends AbstractController
{
    #[Route('/add/{id}', name: 'add',requirements: ["id"=>"\d+"])]
    public function index(
        SerieRepository $serieRepository,
        int $id,
        SeasonRepository $seasonRepository,
        Request $request): Response

    {
        $serie=$serieRepository->find($id);

        $season = new Season();
        $season->setSerie($serie);
        $seasonForm = $this->createForm(SeasonType::class,$season);
        $seasonForm->handleRequest($request);
        if($seasonForm->isSubmitted()&&$seasonForm->isValid()){

            /**
             * @var UploadedFile $file
             */
            //IMAGE /!\/!\
            $file = $seasonForm->get('poster')->getData();

            if($file){
                $newFileName = $season->getSerie()->getName().
                    "-".$season->getNumber()."-".uniqid().".".
                    $file->guessExtension();
                $file->move('img/posters/seasons',$newFileName);
                $season->setPoster($newFileName);

            }

            $seasonRepository->save($season,true);
            $this->addFlash('succes',"Season added on ".$season->getSerie()->getName()."!");
            return $this->render('serie/show.html.twig', ['id' =>$season->getSerie()->getId()

            ]);

        }


        return $this->render('season/add.html.twig', ["seasonForm"=>$seasonForm->createView()

        ]);
    }
}
