<?php

namespace App\Service;

use App\Entity\Films;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class SaveApiFilmService {

    public function __construct(private GenreRepository $genreRepository, private EntityManagerInterface $entityManager){}

    public function saveFilm($array){
        $array = json_decode($array, true);
        $genre = $array['Genre'];
        $film = new Films();
        $genres = explode(", ", $genre);
        foreach($genres as $genre){
            if($this->genreRepository->findOneByNom($genre) == null) {
                $genreAdd = new Genre();
                $genreAdd->setNom($genre);
                $this->entityManager->persist($genreAdd);
                $this->entityManager->flush();
            }
            $genre = $this->genreRepository->findOneByNom($genre);
            
            // création du genre associé au film
            $film->addGenre($genre);
        }
        
        // création du film 
        $film->setCountry($array['Country']);
        $film->setPlot($array['Plot']);
        $film->setPoster($array['Poster']);
        if(str_contains('PG', $array['Rated'])){
            $film->setAge(13);
        }
        else $film->setAge(17);
        // bien formatter la date
        $date = new DateTimeImmutable($array['Year'] . '-01-01');
        $film->setRealeaseAt($date);
        $film->setTitle($array['Title']);
        $this->entityManager->persist($film);
        $this->entityManager->flush();
    }
}