<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Station;
use App\Form\BilletType;
use App\Form\StationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
 use App\Repository\billetRepository;
 use Knp\Component\Pager\PaginatorInterface;
 use App\Repository\StationRepository;

class AcceuilController extends AbstractController
{
    #[Route('/home', name: 'app_acceuil')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/listebilletsreserves', name: 'liste_billets_reserves')]
    public function listebilletsreserves(): Response
    {
        return $this->render('home/listebilletreserves.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    
    #[Route('/transport', name: 'app_transport')]
    public function reserver(Request $req,ManagerRegistry $Manager,billetRepository $repo,PaginatorInterface $paginator): Response
    {   $em=$Manager->getManager();
        $list=$repo->findAll();
        $billet=new billet();
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
            $list = $paginator->paginate(
                $list, /* query NOT result */
                $req->query->getInt('page', 1),
                3
            );
        return $this->render('home/transport.html.twig', [
           
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

#[Route('/DeleteBillet{id}', name: 'delete_billet')] 
public function deleteAuthor(ManagerRegistry $Manager,billetRepository $repo,$id):Response
{
    $em=$Manager->getManager();
    $billet=$repo->find($id);
    $em->remove($billet);
    $em->flush();
    return $this->redirectToRoute('app_transport');
}
}