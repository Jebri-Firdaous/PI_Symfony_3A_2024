<?php

namespace App\Controller;
use App\Controller\ReservationController;
use Psr\Container\ContainerInterface;
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
    public function index(ContainerInterface $container): Response
    {
        return $this->render('Front/index.html.twig', [
            'controller_name' => 'AcceuilController',
            'container' => $container,
        ]);
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(ContainerInterface $container): Response
    {
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'AcceuilController',
            'container' => $container,
        ]);
    }
    #[Route('/transport', name: 'app_transport')]
    public function transportHome(): Response
    {
        return $this->render('Front/transport.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/parking', name: 'app_parking')]
    public function parkingHome(): Response
    {
        return $this->render('Front/parking.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/sante', name: 'app_sante')]
    public function santeHome(): Response
    {
        return $this->render('Front/sante.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/shopping', name: 'app_shopping')]
    public function shoppingHome(): Response
    {
        return $this->render('Front/shopping.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/tourism', name: 'app_tourisme')]
    public function tourismHome(): Response
    {
        return $this->render('Front/tourism.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/contact', name: 'app_contact')]
    public function contactHome(): Response
    {
        return $this->render('Front/contact.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/SignIn', name: 'app_signIn')]
    public function signIn(): Response
    {
        
        return $this->render('Front/signIn.html.twig', [
           
        ]);
    }

    #[Route('/addReservation', name: 'app_tourisme')]
public function tourismeHome(Request $request, EntityManagerInterface $entityManager): Response
{
    return $this->redirectToRoute('app_reservation_new');
}
   




}
