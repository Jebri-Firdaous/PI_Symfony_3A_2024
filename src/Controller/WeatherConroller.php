<?php

namespace App\Controller;

use App\Entity\Hotel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function index(): Response
    {
        // Récupérer tous les hôtels depuis la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $hotels = $entityManager->getRepository(Hotel::class)->findAll();

        $weatherData = [];

        // Récupérer les données météorologiques pour chaque adresse d'hôtel
        $apiKey = 'f9c6b940fe371fd2d6824cdf565e0a60';
        $httpClient = HttpClient::create();

        foreach ($hotels as $hotel) {
            $address = $hotel->getAdressHotel();
            if ($address) {
                $response = $httpClient->request('GET', "http://api.openweathermap.org/data/2.5/weather?q={$address}&appid={$apiKey}");
                $weatherData[$address] = $response->toArray();
            }
        }

        return $this->render('Front/weather/index.html.twig', [
            'weatherData' => $weatherData,
        ]);
    }

}
