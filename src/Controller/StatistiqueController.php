<?php

// src/Controller/StatistiqueController.php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'app_statistique')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $reservationStatistics = $reservationRepository->getreservationStatistics();

        $labels = [];
        $data = [];

        foreach ($reservationStatistics as $statistic) {
            $labels[] = $statistic['typeChambre'];
            $data[] = $statistic['count'];
        }

        return $this->render('Back/statistique/reservation.html.twig', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
        ]);
    }
  
}