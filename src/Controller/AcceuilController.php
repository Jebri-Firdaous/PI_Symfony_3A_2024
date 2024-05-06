<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClientRepository;

class AcceuilController extends AbstractController
{
    #[Route('/home', name: 'app_acceuil')]
    public function index(ClientRepository $c): Response
    {
        // Starting or resuming a session
        session_start();
        // $_SESSION['user'] = $c->find(48);

        // Adding a variable to the session
        $_SESSION['user_id'] = 65;

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
        return $this->render('Front/parking/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}
