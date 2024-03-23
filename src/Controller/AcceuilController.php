<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Station;
use App\Form\BilletType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

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
    public function reserver(Request $req,ManagerRegistry $Manager): Response
    {   $em=$Manager->getManager();

        $billet=new billet();
        $form=$this->createForm(BilletType::class,$billet);
        $form->handleRequest($req);
        if ($form ->isSubmitted())
        {
        $em->persist($billet);
        $em->flush();
       
        return $this->redirectToRoute('app_transport');
        }
        else {
        return $this->render('home/transport.html.twig', [
            'f'=>$form->createView()
        ]);
    }}
}
