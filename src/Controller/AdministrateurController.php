<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Personne;
use App\Form\AdministrateurType;
use App\Form\PersonneType;
use App\Repository\AdministrateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrateurController extends AbstractController
{
    #[Route('/adminGetAll', name: 'administrateur_list')]
    public function listAdministrateur(AdministrateurRepository $repo): Response
    {
        $list=$repo->findAll();
        return $this->render('Back/administrateur/index.html.twig', [
            'list' => $list,
        ]);
    }
    #[Route('/addAdmin', name: 'app_administrateur_add')]
    public function addAdmin(Request $request, ManagerRegistry $manager): Response {
        $administrateur = new Administrateur();
    
        $form = $this->createForm(AdministrateurType::class, $administrateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $manager->getManager();
            $entityManager->persist($administrateur);
            $entityManager->flush();
    
            return $this->redirectToRoute('administrateur_list');
        }
    
        return $this->render('Back/administrateur/addAdmin.html.twig', [
            'form_admin' => $form->createView(),
        ]);
    }
    #[Route('/editAdmin/{id}', name: 'app_administrateur_edit')]
    public function editAdmin(Request $request, ManagerRegistry $manager, AdministrateurRepository $repo, $id): Response {
        $entityManager = $manager->getManager();

        $administrateur= $repo->find($id);
        $form = $this->createForm(AdministrateurType::class, $administrateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            $entityManager->persist($administrateur);
            $entityManager->flush();
    
            return $this->redirectToRoute('administrateur_list');
        }
    
        return $this->render('Back/administrateur/addAdmin.html.twig', [
            'form_admin' => $form->createView(),
        
        ]);
    }
    #[Route('/deleteAdmin/{id}', name: 'app_administrateur_delete')]
    public function deleteAdmin(ManagerRegistry $manager, AdministrateurRepository $repo, $id): Response {
        $entityManager = $manager->getManager();

        $administrateur= $repo->find($id);    
       
        $entityManager->remove($administrateur);
        $entityManager->flush();
    
        return $this->redirectToRoute('administrateur_list');
        

    
    }
}