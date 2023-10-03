<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmsController extends AbstractController
{

    private $tableau = [
        [
            'date' => '00/00/00',
            'nom' => 'Test',
            'real' => 'BLBL blbl',
            'type' => ['Humour'],
            'id' => 1,
        ],
        [
            'date' => '00/00/00',
            'nom' => 'AAAAAAAA',
            'real' => 'BLBL blbl',
            'type' => ['Action', 'Humour'],
            'id' => 2,
        ],
        [
            'date' => '00/00/00',
            'nom' => 'blbl',
            'real' => 'BLBL blbl',
            'type' => ['Action', 'Humour'],
            'id' => 3,
        ],
        [
            'date' => '00/00/00',
            'nom' => 'Test2',
            'real' => 'BLBL blbl',
            'type' => ['Action'],
            'id' => 4,
        ],
    ];

    #[Route('/films', name: 'app_films')]
    public function liste(): Response
    {
        return $this->render('films/index.html.twig', [
            'films' => $this->tableau,
        ]);
    }

    #[Route('/films/{idFilm<\d+>}', name: 'films_detail')]
    public function index(int $idFilm = 0): Response
    {
        return $this->render('films/details.html.twig', [
            'film' => $this->tableau[$idFilm - 1]
        ]);
    }
}
