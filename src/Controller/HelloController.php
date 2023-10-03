<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

    #[Route('/hello/{name}', name: 'app_hello')]
    public function helloName($name = ''): Response {
        return $this->render('hello/index.html.twig', [
            'name' => $name,
        ]);
    }
}