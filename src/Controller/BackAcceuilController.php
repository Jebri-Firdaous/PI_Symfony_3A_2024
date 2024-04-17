<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class BackAcceuilController extends AbstractController
{
    #[Route('/back/acceuil', name: 'app_back_acceuil')]
    public function index(): Response
    {
        return $this->render('Back/index.html.twig', [
            'controller_name' => 'BackAcceuilController',
        ]);
    }

  

}