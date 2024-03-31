<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Personne;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ClientRepository as ClientRepository;


#[Route('Front/client')]
class ClientController extends AbstractController
{
  private $entityManager;
    private $clientRepository;

    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
    }

    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('Front/client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $formData = $form->getData();
            
            $personne = new Personne();
            $personne->setNomPersonne("fj");
            $personne->setPrenomPersonne("jj");
            $personne->setNumeroTelephone("24500297");
            $personne->setMailPersonne("mail@gmail.com");
            $personne->setMdpPersonne("Azertiop");
            $personne->setImagePersonne("img");
    
            $client = new Client();
            $client->setAge("25");
            $client->setGenre("Femme");
            $client->setPersonne($personne);
            dump($personne);
    
            $entityManager->persist($personne);
            $entityManager->persist($client);
            $entityManager->flush();
    
            return new Response(
                'Saved new admin with id: ' . $client->getPersonne()->getNomPersonne() . $client->getPersonne()->getId() 
                .' and new personne with id: '.$personne->getId()
            );
        }
    
        // Si le formulaire n'est pas soumis ou n'est pas valide, afficher le formulaire
        return $this->render('Front/client/new.html.twig', [
            'form' => $form->createView(),
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

    $client = new client();
    $client->setAge(25);
    $client->setGenre(25);

    $client->setPersonne($personne);
    dump($personne);

    // relates this product to the category
    // $client->setIdPersonne($personne);

    $entityManager = $doctrine->getManager();

    $entityManager->persist($personne);
    // $entityManager->flush();
    $entityManager->persist($client);
    $entityManager->flush();

    return new Response(
        'Saved new admin with id: ' . $client->getPersonne()->getNomPersonne() . $client->getPersonne()->getId() 
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
    $client = $doctrine->getRepository(client::class)->find(55);


    return new Response(
        'fetch old admin ' . $client->getPersonne()->getNomPersonne() . $client->getPersonne()->getId() 
        . $client->getRole()
        // .' and new personne with id: '.$personne->getId()
    );
}
    #[Route('/{idPersonne}', name: 'app_client_show', methods: ['GET'])]
    public function show(int $idPersonne): Response
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($idPersonne);
    
        if (!$client) {
            throw $this->createNotFoundException('Client not found');
        }
    
        return $this->render('Front/client/show.html.twig', [
            'client' => $client,
        ]);
    }
    #[Route('/{idPersonne}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{idPersonne}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getPersonne(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
