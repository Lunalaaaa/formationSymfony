<?php

namespace App\Controller;

use App\Event\AccessMovieEvent;
use App\EventSubscriber\AccessMovieSubscriber;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FilmsRepository;
use App\Repository\UserRepository;
use App\Service\OmdbApiConsumer;
use App\Service\SaveApiFilmService;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class FilmsController extends AbstractController
{

    public function __construct(private OmdbApiConsumer $omdb, private SaveApiFilmService $saveService, private EventDispatcherInterface $dispatcher)
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
        $film = $filmRepo->findOneById($idFilm);

        /** 
         * @var \App\Entity\User $user 
         */
        $user = $this->getUser();

        if($user->getAge() < $film->getAge()){
            $event = new AccessMovieEvent($film);
            $this->dispatcher->dispatch($event);
        }
        return $this->render('films/details.html.twig', [
            'film' => $film
        ]);
    }

    #[Route(path: '/films/testApi/{nomFilm}', name: 'testApi')]
    public function getInfosFromService($nomFilm = 'Spider man'){
        $this->saveService->saveFilm($this->omdb->getInfos($nomFilm)->getContent());
        return $this->redirectToRoute('app_films_crud_index');
    }

    #[Route(path: '/test', name: 'test')]
    public function test(UserRepository $userRepository){
        dd($userRepository->findAllByAdmin());
    }
}
