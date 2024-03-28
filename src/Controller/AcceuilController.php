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
    #[Route('/homeBack', name: 'app_acceuil_back')]
    public function indexback(): Response
    {
        return $this->render('home/index2.html.twig', [
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
    #[Route('/shopping', name: 'app_shopping')]
    public function shoppingHome(): Response
    {
        return $this->render('home/shopping.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
}
