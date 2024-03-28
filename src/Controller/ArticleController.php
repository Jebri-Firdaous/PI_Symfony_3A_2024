<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Commande;
use App\Entity\CommandeArticle;
use App\Form\CommandeType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use DateTime; 
use Symfony\Component\Form\FormError;




#[Route('/article')]
class ArticleController extends AbstractController
{
    
    #[Route('/article/{id}/add-to-cart', name: 'article_add_to_cart')]
    public function addToCart(Article $article, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $id = $article->getIdArticle();

        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id' => $article->getIdArticle(),
                'nomArticle' => $article->getNomArticle(),
                'prixArticle' => $article->getPrixArticle(),
                'quantity' => 1
            ];
        } else {
            $cart[$id]['quantity']++;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_article_index');
    }



    #[Route('/cart', name: 'cart_index')]
    public function cart(SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        // Afficher le contenu du panier
        return $this->render('article/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/checkout', name: 'cart_checkout')]
    public function checkout(SessionInterface $session, EntityManagerInterface $entityManager, ArticleRepository $articleRepository, FlashBagInterface $flashBag): Response
    {
        // Récupérer le contenu du panier
        $cart = $session->get('cart', []);

        // Créer une nouvelle commande
        $commande = new Commande();

        // Calculer le prix total
        $total = 0;
        foreach ($cart as $itemId => $item) {
            $article = $articleRepository->find($itemId);
            if ($article) {
                $total += $article->getPrixArticle() * $item['quantity'];
            }
        }

        // Calculer la date limite de commande (2 jours à partir d'aujourd'hui)
        $limitDate = new DateTime();
        $limitDate->add(new \DateInterval('P2D'));

        // Assigner les valeurs à la commande
        $totalArticles = array_sum(array_column($cart, 'quantity'));
        $commande->setNombreArticle($totalArticles);
        $commande->setPrixTotale($total);
        $commande->setDelaisCommande($limitDate);

        // Enregistrer la commande dans la base de données
        $entityManager->persist($commande);

        // Enregistrer les articles associés à cette commande dans la table commande_article
        foreach ($cart as $itemId => $item) {
            $article = $articleRepository->find($itemId);
            if ($article) {
                $commandeArticle = new CommandeArticle();
                $commandeArticle->setIdCommande($commande);
                $commandeArticle->setIdArticle($article);
                $entityManager->persist($commandeArticle);
            }
        }

        // Vider le panier
        $session->set('cart', []);

        // Exécuter les opérations de base de données
        $entityManager->flush();

        // Ajouter un message flash de confirmation
        $flashBag->add('success', 'Votre commande a été passée avec succès.');

        // Rediriger vers les informations de la commande
        return $this->redirectToRoute('app_commande_show', ['idCommande' => $commande->getIdCommande()]);
    }



    
#[Route('/cart/place-order', name: 'cart_place_order')]
public function placeOrder(SessionInterface $session, EntityManagerInterface $entityManager, ArticleRepository $articleRepository, FlashBagInterface $flashBag): Response
{
    // Récupérer le contenu du panier
    $cart = $session->get('cart', []);

    // Créer une nouvelle commande
    $commande = new Commande();

    // Calculer le prix total
    $total = 0;
    foreach ($cart as $itemId => $item) {
        $article = $articleRepository->find($itemId);
        if ($article) {
            $total += $article->getPrixArticle() * $item['quantity'];
        }
    }

    // Calculer la date limite de commande (2 jours à partir d'aujourd'hui)
    $limitDate = new DateTime();
    $limitDate->add(new \DateInterval('P2D')); // Utilisation correcte de DateInterval

    // Calculer le nombre total d'articles dans le panier
    $totalArticles = array_sum(array_column($cart, 'quantity'));

    // Assigner les valeurs à la commande
    $commande->setNombreArticle($totalArticles); // Assigner le nombre total d'articles
    $commande->setPrixTotale($total);
    $commande->setDelaisCommande($limitDate);

    // Enregistrer la commande dans la base de données
    $entityManager->persist($commande);
    $entityManager->flush();

    // Enregistrer les articles associés à cette commande dans la table commande_article
    foreach ($cart as $itemId => $item) {
        $article = $articleRepository->find($itemId);
        if ($article) {
            $commandeArticle = new CommandeArticle();
            $commandeArticle->setIdCommande($commande);
            $commandeArticle->setIdArticle($article);
            $entityManager->persist($commandeArticle);
        }
    }
    $entityManager->flush();

    // Vider le panier
    $session->set('cart', []);

    // Ajouter un message flash de confirmation
    $flashBag->add('success', 'Votre commande a été passée avec succès.');

    // Rediriger vers les informations de la commande
    return $this->redirectToRoute('app_commande_show', ['idCommande' => $commande->getIdCommande()]);
}




    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    
    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
public function new(Request $request): Response
{
    $article = new Article();
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Gérer le téléchargement de l'image
        $file = $form->get('photoArticle')->getData();
        if ($file) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('photos_directory'),
                $fileName
            );
            // Construire l'URL complète de l'image
            $photoArticle = $this->getParameter('photos_directory') . '/' . $fileName;
            $article->setPhotoArticle($photoArticle); // Enregistrez l'URL de l'image dans l'entité
        }

        // Enregistrer l'article dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('app_article_index');
    }

    return $this->render('article/new.html.twig', [
        'form' => $form->createView(),
    ]);

}

    #[Route('/{idArticle}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{idArticle}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{idArticle}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getIdArticle(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
