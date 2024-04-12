<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/tourism', name: 'app_tourism')]
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

}
