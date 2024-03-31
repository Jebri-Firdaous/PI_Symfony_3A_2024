<?php

namespace App\Controller;

use App\Entity\Administrateur;
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
use App\Repository\MedecinRepository;
use App\Repository\RendezVousRepository;

class RendezVousController extends AbstractController
{
    #[Route('/rendez/vous', name: 'app_rendez_vous')]
    public function index(): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }

    #[Route('/testsaving', name: 'rv')]
    public function test(ManagerRegistry $doctrine): Response
    {
        $personne = new Personne();
        $personne->setNomPersonne('df');
        $personne->setPrenomPersonne('badfhira');
        $personne->setMailPersonne('kajofm');
        $personne->setMdpPersonne('kafdrfim');
        $personne->setImagePersonne('kardfim');
        $personne->setNumeroTelephone(4576);

        $administrateur = new Administrateur();
        $administrateur->setRole("gestion Medecin");
        $administrateur->setPersonne($personne);
        dump($personne);

        // relates this product to the category
        // $client->setIdPersonne($personne);

        $entityManager = $doctrine->getManager();

        $entityManager->persist($personne);
        // $entityManager->flush();
        $entityManager->persist($administrateur);
        $entityManager->flush();

        return new Response(
            'Saved new admin with id: ' . $administrateur->getPersonne()->getNomPersonne() . $administrateur->getPersonne()->getId() 
            .' and new personne with id: '.$personne->getId()
        );
    }

    #[Route('/testFetchClient', name: 'fetclmhtest')]
    public function testFetchClient(ManagerRegistry $doctrine): Response
    {
        $client = $doctrine->getRepository(Client::class)->find(56);
    

        return new Response(
            'fetch old client ' . $client->getPersonne()->getNomPersonne() . $client->getPersonne()->getId() . "genre" . $client->getGenre()
            // .' and new personne with id: '.$personne->getId()
        );

    }
    #[Route('/testFetchAdmin', name: 'fetchtest')]
    public function testFetch(ManagerRegistry $doctrine): Response
    {
        $administrateur = $doctrine->getRepository(Administrateur::class)->find(55);
    

        return new Response(
            'fetch old admin ' . $administrateur->getPersonne()->getNomPersonne() . $administrateur->getPersonne()->getId() 
            . $administrateur->getRole()
            // .' and new personne with id: '.$personne->getId()
        );
    }
    #[Route('/addRendezVousFront', name: 'front_rendezVous_add')]
    public function addRendezVous(Request $request, ManagerRegistry $doctrine, ClientRepository $clientRepository, MedecinRepository $medecinRepository): Response
    {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        $rendezVous = new RendezVous();

        $personne = $doctrine->getRepository(Personne::class)->find(55);
        dump($personne);

        $client = $clientRepository->find($personne);
        dump($client);
        $rendezVous->setIdPersonne($client);

        
        // $rendezVous->setIdPersonne($client);
        $entityManager->persist($rendezVous);
        $form = $this->createForm(RendezVousType::class, $rendezVous, ['medecinRepository' => $medecinRepository]);
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
            return $this->redirectToRoute('front_rendezVous_getAll');
        }

        return $this->render('Front/rendez_vous/addRendezVous.html.twig', [
            'controller_name' => 'RendezVousController',
            'form' => $form->createView(),

        ]);
    }
    #[Route('/Rvbyclient', name: 'front_rendezVous_getAll')]
    public function showAllRendezVousBySession(RendezVousRepository $rendezVousRepository,MedecinRepository $medecinRepository ,ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->find(55);
        dump($client);
        $lesRendezVousByClient =  $client->getLesRendezVous();
        dump($lesRendezVousByClient);

        return $this->render('Front/rendez_vous/showRV.html.twig', [
            'controller_name' => 'RendezVousController',
            'lesRVdeClient' => $lesRendezVousByClient,
        ]);
    }
    #[Route('/deleteRVFront/{id}', name: 'front_rendezVous_delete')]
    public function deleteRendezVous(Request $request, ManagerRegistry $doctrine, RendezVousRepository $rendezVousRepository, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        dump($id);

        $rendezVous = $rendezVousRepository->find($id);
        dump($rendezVous);

        
        // $rendezVous->setIdPersonne($client);
        $entityManager->remove($rendezVous);
        $entityManager->flush();

        return $this->redirectToRoute('front_rendezVous_getAll');

      
    }
    #[Route('/editRVFront/{id}', name: 'front_rendezVous_edit')]
    public function editRendezVousbyclient(Request $request, ManagerRegistry $doctrine, RendezVous $rendezVous ,RendezVousRepository $rendezVousRepository, int $id): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            // $entityManager->persist($product), but it isn't necessary: 
            // Doctrine is already "watching" your object for changes.
            $entityManager->flush();
            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('front_rendezVous_getAll');
        }
        
        return $this->render('Front/rendez_vous/editRendezVous.html.twig', [
            'rendezvous' => $rendezVous,
            'form' => $form->createView(),
        ]);

      
    }


    
    #[Route('/allRVExist', name: 'back_rendezVous_getAll')]
    public function showAllRendezVousForAdmin(RendezVousRepository $rendezVousRepository,MedecinRepository $medecinRepository ,ClientRepository $clientRepository): Response
    {
        $allRVInDB = $rendezVousRepository->findAll();
        dump($allRVInDB);

        return $this->render('Back/rendezVous/showAllRvInDB.html.twig', [
            'controller_name' => 'RendezVousController',
            'lesRVdeClient' => $allRVInDB,
        ]);
    }
}
