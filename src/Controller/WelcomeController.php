<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/welcome', name: 'app_welcome')]
    public function index(): Response
    {
        return $this->render('Welcome_Page.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }
    #[Route('/home', name: 'app_acceuil')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }

}
