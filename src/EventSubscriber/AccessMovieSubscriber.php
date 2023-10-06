<?php

namespace App\EventSubscriber;

use App\Event\AccessMovieEvent;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AccessMovieSubscriber implements EventSubscriberInterface{
    
    public function __construct(private UserRepository $userRepository){}

    public function onMovieEvent(AccessMovieEvent $event){
        dd($this->userRepository->findAllByAdmin());
    }

    public static function getSubscribedEvents(){
        return [
            AccessMovieEvent::class => 'onMovieEvent'
        ];
    }
}