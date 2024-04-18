<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back')]
class BackAcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'app_back_acceuil')]
    public function index(): Response
    {
        return $this->render('Back/index.html.twig', [
            'controller_name' => 'BackAcceuilController',
        ]);
    }
}
