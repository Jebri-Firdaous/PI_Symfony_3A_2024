<?php

namespace App\Controller;

use App\Entity\CommandeArticle;
use App\Form\CommandeArticleType;
use App\Repository\CommandeArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/commande/article')]
class CommandeArticleController extends AbstractController
{
    #[Route('/', name: 'app_commande_article_index', methods: ['GET'])]
    public function index(CommandeArticleRepository $commandeArticleRepository): Response
    {
        return $this->render('commande_article/index.html.twig', [
            'commande_articles' => $commandeArticleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commandeArticle = new CommandeArticle();
        $form = $this->createForm(CommandeArticleType::class, $commandeArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandeArticle);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_article/new.html.twig', [
            'commande_article' => $commandeArticle,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommande}', name: 'app_commande_article_show', methods: ['GET'])]
    public function show(CommandeArticle $commandeArticle): Response
    {
        return $this->render('commande_article/show.html.twig', [
            'commande_article' => $commandeArticle,
        ]);
    }

    #[Route('/{idCommande}/edit', name: 'app_commande_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CommandeArticle $commandeArticle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeArticleType::class, $commandeArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_article/edit.html.twig', [
            'commande_article' => $commandeArticle,
            'form' => $form,
        ]);
    }

    #[Route('/confirmation-commande', name: 'confirmation_commande')]
    public function confirmationCommande(SessionInterface $session): Response
    {
        // Récupérer l'identifiant de la dernière commande ajoutée
        $lastCommandeId = $session->get('last_commande_id');
    
        // Rediriger vers la page de détails de la commande
        return $this->redirectToRoute('app_commande_show', ['idCommande' => $lastCommandeId]);
    }
    
}
