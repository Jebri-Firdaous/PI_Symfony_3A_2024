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
        return $this->render('home/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/transport', name: 'app_transport')]
    public function transportHome(): Response
    {
        return $this->render('home/transport.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/welcome', name: 'app_welcome')]
    public function WelcomeHome(): Response
    {
        return $this->render('home/welcome.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}
