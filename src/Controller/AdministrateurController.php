<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Client;
use App\Entity\Personne;
use App\Form\AdministrateurType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrateur')]
class AdministrateurController extends AbstractController
{
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
    #[Route('/', name: 'app_administrateur_index', methods: ['GET'])]
    public function index(AdminRepository $adminRepository): Response
    {
        return $this->render('administrateur/index.html.twig', [
            'administrateurs' => $adminRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_administrateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $administrateur = new Administrateur();
        $form = $this->createForm(AdministrateurType::class, $administrateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($administrateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_administrateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('administrateur/new.html.twig', [
            'administrateur' => $administrateur,
            'form' => $form,
        ]);
    }

    #[Route('/{personne}', name: 'app_administrateur_show', methods: ['GET'])]
    public function show(Administrateur $administrateur): Response
    {
        return $this->render('administrateur/show.html.twig', [
            'administrateur' => $administrateur,
        ]);
    }
    

    #[Route('/{personne}/edit', name: 'app_administrateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Administrateur $administrateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdministrateurType::class, $administrateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_administrateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('administrateur/edit.html.twig', [
            'administrateur' => $administrateur,
            'form' => $form,
        ]);
    }

    #[Route('/{personne}', name: 'app_administrateur_delete', methods: ['POST'])]
    public function delete(Request $request, Administrateur $administrateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$administrateur->getPersonne(), $request->request->get('_token'))) {
            $entityManager->remove($administrateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_administrateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
