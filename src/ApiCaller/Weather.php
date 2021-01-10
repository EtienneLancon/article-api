<?php

namespace App\ApiCaller;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;

class Weather
{
    private $weatherClient;
    private $serializer;
    private $apiKey;

    public function __construct(Client $weatherClient, Serializer $serializer, $apiKey)
    {
        $this->weatherClient = $weatherClient;
        $this->serializer = $serializer;
        $this->apiKey = $apiKey;
    }

    public function getCurrent()
    {
        $uri = '/data/2.5/forecast?id=524901&appid='.$this->apiKey;
        
        try {
            $response = $this->weatherClient->get($uri);
        } catch (\Exception $e) {
            // Penser à logger l'erreur.
            
            return ['error' => 'Les informations ne sont pas disponibles pour le moment.'];
        }

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');

        return [
            'city' => $data['city']['name'],
            'description' => $data['list'][0]['weather'][0]['description']
        ];
    }
}