<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackAcceuilController extends AbstractController
{
    #[Route('/back/acceuil', name: 'app_back_acceuil')]
    public function index(): Response
    {
        return $this->render('Back/index.html.twig', [
            'controller_name' => 'BackAcceuilController',
        ]);
    }
    #[Route('/article', name: 'app_article_index_back')]
    public function article(): Response
    {
        return $this->render('Back/index.html.twig', [
            'controller_name' => 'BackAcceuilController',
        ]);
    
    }
    #[Route('/commande', name: 'app_commande_index_back')]
    public function commande(): Response
    {
        return $this->render('Back/index.html.twig', [
            'controller_name' => 'BackAcceuilController',
        ]);
    }
    #[Route('/place', name: 'app_place_index_back')]
    public function place(): Response
    {
        return $this->render('Back/index.html.twig', [
            'controller_name' => 'BackAcceuilController',
        ]);
    }
}
