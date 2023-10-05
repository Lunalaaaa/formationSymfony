<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FilmsRepository;
use App\Service\OmdbApiConsumer;
use App\Service\SaveApiFilmService;

class FilmsController extends AbstractController
{

    public function __construct(private OmdbApiConsumer $omdb, private SaveApiFilmService $saveService)
    {
        
    }

    // #[Route('/films', name: 'app_films')]
    public function liste(FilmsRepository $filmRepo): Response
    {
        return $this->render('films/index.html.twig', [
            'films' => $filmRepo->findBy(array(), array(), 3),
        ]);
    }

    #[Route('/films/{idFilm<\d+>}', name: 'films_detail')]
    public function index(int $idFilm = 1, FilmsRepository $filmRepo): Response
    {
        return $this->render('films/details.html.twig', [
            'film' => $filmRepo->findOneById($idFilm)
        ]);
    }

    #[Route(path: '/films/testApi/{nomFilm}', name: 'testApi')]
    public function getInfosFromService($nomFilm = 'Spider man'){
        $this->saveService->saveFilm($this->omdb->getInfos($nomFilm)->getContent());
        return $this->redirectToRoute('app_films_crud_index');
    }
}
