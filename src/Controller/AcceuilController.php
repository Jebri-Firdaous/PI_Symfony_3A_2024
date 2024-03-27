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
 use App\Repository\billetRepository;

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
    public function reserver(Request $req,ManagerRegistry $Manager,billetRepository $repo): Response
    {   $em=$Manager->getManager();
        $list=$repo->findAll();
        $billet=new billet();
        $billet->setPrix('15dt');
        $billet->setDuree('0');
        $form=$this->createForm(BilletType::class,$billet);
        $form->handleRequest($req);
      
        if ($form ->isSubmitted() && $form ->isValid())
        {
        $em->persist($billet);
        $em->flush();
      
        return $this->redirectToRoute('app_transport');
        }
        
        else {
            $list = $repo->findAll();
        return $this->render('home/transport.html.twig', [
            'f'=>$form->createView(),
            'list' => $list
        ]);
    }}


#[Route('/EditBillet/{id}', name: 'edit_billet')] 
public function editBillet (Request $req,ManagerRegistry $Manager,billetRepository $repo,$id)
:Response {
    $em=$Manager->getManager();
    $billet=$repo->find($id);
    $form=$this->createForm(BilletType::class,$billet);
    $form->handleRequest($req);
    if ($form ->isSubmitted())
    {
    $em->persist($billet);
    $em->flush();
   
    return $this->redirectToRoute('app_transport');
    }
    else {
        $list = $repo->findAll();
    return $this->renderForm('home/transport.html.twig',
    ['f'=>$form,
    'list' => $list
    ]
);
}}
#[Route('/DeleteAuthor/{id}', name: 'delete_billet')] 
public function deleteAuthor(ManagerRegistry $Manager,billetRepository $repo,$id):Response
{
    $em=$Manager->getManager();
    $billet=$repo->find($id);
    $em->remove($billet);
    $em->flush();
    return $this->redirectToRoute('app_transport');
}
}