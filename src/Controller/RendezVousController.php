<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Personne;
use App\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\RendezVousType;
use App\Repository\ClientRepository as ClientRepository;




class RendezVousController extends AbstractController
{
    #[Route('/rendez/vous', name: 'app_rendez_vous')]
    public function index(): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }

    #[Route('/rv', name: 'rv')]
    public function test(ManagerRegistry $doctrine): Response
    {
        $personne = new Personne();
        $personne->setNomPersonne('karim');
        $personne->setPrenomPersonne('karim');
        $personne->setMailPersonne('karim');
        $personne->setMdpPersonne('karim');
        $personne->setImagePersonne('karim');


        $client = new Client();
        $client->setAge(20);
        $id_personne = $personne->getIdPersonne();

        // relates this product to the category
        $client->setIdPersonne($id_personne);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($personne);
        
        $entityManager->persist($client);
        $entityManager->flush();

        return new Response(
            'Saved new product with id: '.$client->getIdPersonne()
            .' and new category with id: '.$personne->getNomPersonne()
        );
    }
    #[Route('/addRendezVous', name: 'app_rendezVous_add')]
    public function addRendezVous(Request $request, ManagerRegistry $doctrine, ClientRepository $clientRepository): Response
    {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        $rendezVous = new RendezVous();
        // $client = $clientRepository->findClientById(58);
        // dump($client);
        // $rendezVous->setIdPersonne($client);
        $entityManager->persist($rendezVous);
        $form = $this->createForm(RendezVousType::class, $rendezVous); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->get('id_personne')->setData(34); // Set id_personne to 34
            // holds the submitted values
            // but, the original `$task` variable has also been updated
            $rendezVous = $form->getData();
            // TODO ... perform some action, such as saving the task to the database
            $entityManager->flush();
            // return $this->redirectToRoute('app_medecin_getAll');
            return $this->redirectToRoute('app_rendezVous_getAll');
        }

        return $this->render('rendez_vous/addRendezVous.html.twig', [
            'controller_name' => 'RendezVousController',
            'form' => $form->createView(),

        ]);
    }
    #[Route('/allRv', name: 'app_rendezVous_getAll')]
    public function showAllRendezVousBySession(): Response
    {
        return $this->render('rendez_vous/showRV.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }
}
