<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CommandeArticle;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('Front/commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }
    #[Route('/back', name: 'app_commande_index_back', methods: ['GET'])]
public function indexBack(CommandeRepository $commandeRepository, EntityManagerInterface $entityManager): Response
{
    // Récupérer toutes les commandes
    $commandes = $commandeRepository->findAll();

    // Récupérer les articles associés à chaque commande
    $articlesParCommande = [];
    foreach ($commandes as $commande) {
        $commandeArticles = $entityManager->getRepository(CommandeArticle::class)->findBy(['idCommande' => $commande->getIdCommande()]);
        $articles = [];
        foreach ($commandeArticles as $commandeArticle) {
            $articles[] = $commandeArticle->getIdArticle();
        }
        $articlesParCommande[$commande->getIdCommande()] = $articles;
    }

    return $this->render('Back/commande/index.html.twig', [
        'commandes' => $commandes,
        'articlesParCommande' => $articlesParCommande,
    ]);
}

    
    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommande}', name: 'app_commande_show', methods: ['GET'])]
public function show(Commande $commande, EntityManagerInterface $entityManager): Response
{
    // Récupérer les articles associés à chaque commande
    $articlesParCommande = [];
   
        $commandeArticles = $entityManager->getRepository(CommandeArticle::class)->findBy(['idCommande' => $commande->getIdCommande()]);
        $articles = [];
        foreach ($commandeArticles as $commandeArticle) {
            $articles[] = $commandeArticle->getIdArticle();
        }
        $articlesParCommande[$commande->getIdCommande()] = $articles;
    

    return $this->render('Front/commande/show.html.twig', [
        'commande' => $commande,
        'articlesParCommande' => $articlesParCommande,
    ]);
}

#[Route('/back/{idCommande}', name: 'app_commande_show_back', methods: ['GET'])]
public function showback(Commande $commande, EntityManagerInterface $entityManager): Response
{
    // Récupérer les articles associés à chaque commande
    $articlesParCommande = [];
   
        $commandeArticles = $entityManager->getRepository(CommandeArticle::class)->findBy(['idCommande' => $commande->getIdCommande()]);
        $articles = [];
        foreach ($commandeArticles as $commandeArticle) {
            $articles[] = $commandeArticle->getIdArticle();
        }
        $articlesParCommande[$commande->getIdCommande()] = $articles;
    

    return $this->render('Back/commande/show.html.twig', [
        'commande' => $commande,
        'articlesParCommande' => $articlesParCommande,
    ]);
}


    #[Route('/{idCommande}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

   
    
    #[Route('/confirmation-commande', name: 'confirmation_commande')]
public function confirmationCommande(): Response
{
    // Ajoutez ici la logique pour afficher la confirmation de la commande
    return $this->render('confirmation_commande.html.twig'); // Remplacez le nom du template par le vôtre
}
#[Route('/{idCommande}', name: 'app_commande_delete', methods: ['POST'])]
public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$commande->getIdCommande(), $request->request->get('_token'))) {
        // Supprimer les références de commande_article liées à cette commande
        $commandeArticles = $entityManager->getRepository(CommandeArticle::class)->findBy(['idCommande' => $commande]);
        foreach ($commandeArticles as $commandeArticle) {
            $entityManager->remove($commandeArticle);
        }

        // Supprimer la commande elle-même
        $entityManager->remove($commande);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_commande_index_back', [], Response::HTTP_SEE_OTHER);
}

}
