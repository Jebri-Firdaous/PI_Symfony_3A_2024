<?php

namespace App\Controller;
use App\Controller\ReservationController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HotelRepository;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Hotel;
use App\Form\HotelType;
use Doctrine\ORM\EntityManagerInterface;
class AcceuilController extends AbstractController
{
    #[Route('/home', name: 'app_acceuil')]
    public function index(): Response
    {
        return $this->render('Front/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/transport', name: 'app_transport')]
    public function transportHome(): Response
    {
        return $this->render('Front/transport.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/addReservation', name: 'app_tourisme')]
public function tourismeHome(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->redirectToRoute('app_reservation_new');
}
   




}
