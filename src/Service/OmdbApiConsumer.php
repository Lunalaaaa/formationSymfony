<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiConsumer{

    public function __construct(private HttpClientInterface $client){}

    public function getInfos($nomFilm){
        $request = $this->client->request('GET', 
            $_ENV['URL_API'],
            [
                'query' => [
                    'apikey' => $_ENV['API_KEY'],
                    't' => $nomFilm
                ],

            ]
        );
        return new Response($request->getContent());
    }
}