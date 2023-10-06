<?php

namespace App\Event;

use App\Entity\Films;
use Symfony\Contracts\EventDispatcher\Event;

class AccessMovieEvent extends Event
{
    private Films $film;

    public function __construct(Films $film)
    {   
        $this->film = $film;
    }

    public function getFilm(){
        return $this->film;
    }
}