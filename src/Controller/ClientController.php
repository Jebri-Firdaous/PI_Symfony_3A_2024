<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/clientGetAll', name: 'client_list')]
    public function listAdministrateur(ClientRepository $repo): Response
    {
        $list=$repo->findAll();
        return $this->render('Front/client/index.html.twig', [
            'list' => $list,
        ]);
    }
    #[Route('/addClient', name: 'app_client_add')]
    public function addAdmin(Request $request, ManagerRegistry $manager): Response {
        $client = new Client();
    
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $manager->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
    
            return $this->redirectToRoute('client_list');
        }
    
        return $this->render('Front/client/addClient.html.twig', [
            'form_client' => $form->createView(),
        ]);
    }
    #[Route('/editClient/{id}', name: 'app_client_edit')]
    public function editAdmin(Request $request, ManagerRegistry $manager, ClientRepository $repo, $id): Response {
        $entityManager = $manager->getManager();

        $client= $repo->find($id);
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            $entityManager->persist($client);
            $entityManager->flush();
    
            return $this->redirectToRoute('client_list');
        }
    
        return $this->render('Front/client/addClient.html.twig', [
            'form_client' => $form->createView(),
        
        ]);
    }
    #[Route('/deleteClient/{id}', name: 'app_client_delete')]
    public function deleteAdmin(ManagerRegistry $manager, ClientRepository $repo, $id): Response {
        $entityManager = $manager->getManager();

        $client= $repo->find($id);    
       
        $entityManager->remove($client);
        $entityManager->flush();
    
        return $this->redirectToRoute('client_list');
        

    
    }
}