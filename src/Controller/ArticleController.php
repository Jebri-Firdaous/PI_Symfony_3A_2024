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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use BaconQrCode\Encoder\QrCode;
use Knp\Component\Pager\PaginatorInterface;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\RedirectResponse;



use App\Services\QrCodeService;
use Doctrine\DBAL\Connection;
use Knp\Snappy\Pdf;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;





#[Route('/article')]
class ArticleController extends AbstractController
{
    private $session;
   
 

    private $qrcodeService;
    private $paginator;

    public function __construct(QrCodeService $qrcodeService, PaginatorInterface $paginator,private Connection $connection)
    {
        $this->qrcodeService = $qrcodeService;
        $this->paginator = $paginator;
    }
    
    
    #[Route('/search', name: 'app_article_search', methods: ['GET'])]
    public function search(Request $request, ArticleRepository $articleRepository): Response
    {
        $query = $request->query->get('q'); // Terme de recherche

        // Créez une requête pour récupérer les articles avec un filtre de recherche
        $queryBuilder = $articleRepository->createQueryBuilder('a');
        if ($query) {
            $queryBuilder->andWhere('a.nomArticle LIKE :search')
                ->setParameter('search', '%' . $query . '%');
        }

        $articles = $queryBuilder->getQuery()->getResult();

        // Formattez les données pour la réponse JSON
        $formattedArticles = [];
        foreach ($articles as $article) {
            $formattedArticles[] = [
                'nomArticle' => $article->getNomArticle(),
                'prixArticle' => $article->getPrixArticle(),
                'descriptionArticle' => $article->getDescriptionArticle(),
                'typeArticle' => $article->getTypeArticle(),
            ];
        }

        // Retournez la réponse JSON
        return $this->json($formattedArticles);
    }

   

    
    #[Route('/back', name: 'app_article_index_back', methods: ['GET'])]
    public function adminArticles(ArticleRepository $articleRepository, Request $request): Response
    {
        // Récupérer tous les articles avec une requête de base
        $articlesQuery = $articleRepository->createQueryBuilder('a')
            ->getQuery();

        // Paginer les articles
        $articles = $this->paginator->paginate(
            $articlesQuery, // Requête à paginer
            $request->query->getInt('page', 1), // Numéro de page par défaut
            2 // Limiter à 2 articles par page
        );

        $qrCodes = [];
    foreach ($articles as $article) {
        // Générer le QR code pour chaque article
        $qrCodePath = $this->qrcodeService->qrcode($article);
        $qrCodes[$article->getIdArticle()] = $qrCodePath; // Utilisez l'ID de l'article comme clé du tableau
    }

        // Récupérer le numéro de page actuel
        $currentPage = $request->query->getInt('page', 1);

        // Calculer le nombre total de pages en fonction du nombre total d'articles et du nombre par page
        $totalArticlesCount = $articleRepository->createQueryBuilder('a')->select('COUNT(a.idArticle)')->getQuery()->getSingleScalarResult();
        $maxPage = ceil($totalArticlesCount / 2); // 2 articles par page

        return $this->render('Back/article/index.html.twig', [
            'qrCodes' => $qrCodes,
            'articles' => $articles,
            'page' => $currentPage, // Ajouter la variable 'page' au contexte
            'maxPage' => $maxPage, // Ajouter la variable 'maxPage' au contexte
        ]);
    }

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
                'photoArticle' => $article->getPhotoArticle(),
                'quantity' => 1
            ];
        } else {
            $cart[$id]['quantity']++;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_article_index');
    }
    


    #[Route('/article/{id}/add-to-cart/back', name: 'article_add_to_cart_back')]
    public function addToCartBack(Article $article, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $id = $article->getIdArticle();

        if (!isset($cart[$id])) {
            $cart[$id] = [
                'id' => $article->getIdArticle(),
                'nomArticle' => $article->getNomArticle(),
                'prixArticle' => $article->getPrixArticle(),
                'photoArticle' => $article->getPhotoArticle(),
                'quantity' => 1
            ];
        } else {
            $cart[$id]['quantity']++;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_article_index_back2');
    }

    #[Route('/article/{id}/remove-from-cart', name: 'remove_from_cart')]
public function removeFromCart(Article $article, SessionInterface $session): Response
{
    $cart = $session->get('cart', []);
    $id = $article->getIdArticle();

    if (isset($cart[$id])) {
        unset($cart[$id]);
        $session->set('cart', $cart);
    }

    return $this->redirectToRoute('cart_index');
}

#[Route('/article/{id}/remove-from-cart/back', name: 'remove_from_cart_back')]
public function removeFromCartback(Article $article, SessionInterface $session): Response
{
    $cart = $session->get('cart', []);
    $id = $article->getIdArticle();

    if (isset($cart[$id])) {
        unset($cart[$id]);
        $session->set('cart', $cart);
    }

    return $this->redirectToRoute('cart_index_back');
}


    #[Route('/cart', name: 'cart_index')]
    public function cart(SessionInterface $session, ArticleRepository $articleRepository): Response
{
    $cart = $session->get('cart', []);
    $cartWithData = [];
    $total = 0; // Déclaration de la variable 'total'

    foreach ($cart as $itemId => $item) {
        $article = $articleRepository->find($itemId);
        if ($article) {
            $photoArticle = method_exists($article, 'getPhotoArticle') ? $article->getPhotoArticle() : null;
            $cartWithData[] = [
                'id' => $article->getIdArticle(),
                'nomArticle' => $article->getNomArticle(),
                'prixArticle' => $article->getPrixArticle(),
                'quantity' => $item['quantity'],
                'photoArticle' => $photoArticle, // Ajout de la clé "photoArticle"
            ];
            $total += $item['quantity'] * $article->getPrixArticle(); // Calcul du total
        }
    }

    // Stocker le total dans la session
    $session->set('total', $total);

    // Afficher le contenu du panier
    return $this->render('Front/article/cart.html.twig', [
        'cart' => $cartWithData,
        'total' => $total, // Passage de la variable 'total' au rendu Twig
    ]);
}

    #[Route('/cart/back', name: 'cart_index_back')]
    public function cartback(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $cart = $session->get('cart', []);
    $cartWithData = [];
    $total = 0; // Déclaration de la variable 'total'

    foreach ($cart as $itemId => $item) {
        $article = $articleRepository->find($itemId);
        if ($article) {
            $photoArticle = method_exists($article, 'getPhotoArticle') ? $article->getPhotoArticle() : null;
            $cartWithData[] = [
                'id' => $article->getIdArticle(),
                'nomArticle' => $article->getNomArticle(),
                'prixArticle' => $article->getPrixArticle(),
                'quantity' => $item['quantity'],
                'photoArticle' => $photoArticle, // Ajout de la clé "photoArticle"
            ];
            $total += $item['quantity'] * $article->getPrixArticle(); // Calcul du total
        }
    }

         // Afficher le contenu du panier
    return $this->render('Back/article/cart.html.twig', [
        'cart' => $cartWithData,
        'total' => $total, // Passage de la variable 'total' au rendu Twig
    ]);
    }

    #[Route('/cart/checkout', name: 'cart_checkout', methods: ['POST'])]
    public function checkout(
        SessionInterface $session,
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
       
    ): Response {
        // Récupérer le contenu du panier
        $cart = $session->get('cart', []);

        // Calculer le prix total
        $total = $this->calculateTotal($cart, $articleRepository);

        // Créer une nouvelle commande
        $commande = new Commande();

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

        // Créer une session de paiement avec Stripe
        $checkoutSession = $this->createStripeCheckoutSession($total);

        // Rediriger l'utilisateur vers la page de paiement Stripe
        return new RedirectResponse($checkoutSession->url, Response::HTTP_FOUND);
    }

    // Méthode pour créer une session de paiement avec Stripe
    private function createStripeCheckoutSession($total): Session
    {
        // Définir votre clé secrète Stripe
        Stripe::setApiKey('sk_test_51OpYQx2NiuGfqOunOniuM3aEnS7CHNRtCYLb2VZv4clC6ze1b6i1VXBAAlDUUpUZ5rrKqjwthZhFtleAjP8vllzp001ZtxoYFJ');

        // Créer une session de paiement avec Stripe
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur', // Utilisez votre devise
                        'product_data' => [
                            'name' => 'Total Payment',
                        ],
                        'unit_amount' => $total * 100, // Convertir le montant en cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $checkoutSession;
    }

    #[Route('/payment/success', name: 'payment_success')]
public function paymentSuccess(): Response
{
    

    // Rediriger vers les informations de la commande
    return $this->render('Front/article/payment_success.html.twig');
}


    #[Route('/payment/cancel', name: 'payment_cancel')]
    public function paymentCancel(): Response
    {
        // Ajouter un message flash d'erreur
        $this->addFlash('error', 'Votre paiement a été annulé.');

        // Rediriger vers une page de votre choix
        return $this->redirectToRoute('home');
    }

    // Fonction pour calculer le total
    private function calculateTotal(array $cart, ArticleRepository $articleRepository): float
    {
        $total = 0;
        foreach ($cart as $itemId => $item) {
            $article = $articleRepository->find($itemId);
            if ($article) {
                $total += $article->getPrixArticle() * $item['quantity'];
            }
        }
        return $total;
    }


    

    #[Route('/cart/checkout/back', name: 'cart_checkout_back')]
    public function checkout_back(SessionInterface $session, EntityManagerInterface $entityManager, ArticleRepository $articleRepository, FlashBagInterface $flashBag): Response
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
        return $this->redirectToRoute('app_commande_show_back', ['idCommande' => $commande->getIdCommande()]);
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

#[Route('/cart/place-order/back', name: 'cart_place_order_back')]
public function placeOrderback(SessionInterface $session, EntityManagerInterface $entityManager, ArticleRepository $articleRepository, FlashBagInterface $flashBag): Response
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
    return $this->redirectToRoute('app_commande_show_back', ['idCommande' => $commande->getIdCommande()]);
}


#[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $sortOrder = $request->query->get('sortOrder', 'asc'); // Par défaut, tri croissant

        // Récupérer tous les articles avec une requête de base
        $articlesQuery = $articleRepository->createQueryBuilder('a')
            ->orderBy('a.prixArticle', $sortOrder) // Tri par prix
            ->getQuery();

        // Paginer les articles
        $articles = $paginator->paginate(
            $articlesQuery, // Requête à paginer
            $request->query->getInt('page', 1), // Numéro de page par défaut
            8 // Limiter à 4 articles par page
        );

        // Récupérer le numéro de page actuel
        $currentPage = $request->query->getInt('page', 1);

        // Calculer le nombre total de pages en fonction du nombre total d'articles et du nombre par page
        $totalArticlesCount = $articleRepository->createQueryBuilder('a')->select('COUNT(a.idArticle)')->getQuery()->getSingleScalarResult();
        $maxPage = ceil($totalArticlesCount / 4); // 4 articles par page

        // Récupérer les statistiques sur les articles les plus vendus
        $articlesStats = $this->getArticlesStats(

        );

        return $this->render('Front/article/index.html.twig', [
            'articles' => $articles,
            'page' => $currentPage, // Ajouter la variable 'page' au contexte
            'maxPage' => $maxPage, // Ajouter la variable 'maxPage' au contexte
            'articlesStats' => $articlesStats, // Ajouter les statistiques des articles les plus vendus
        ]);
    }

    private function getArticlesStats(): array
{
    $query = "
        SELECT 
            a.id_article,
            a.nom_article,
            a.photo_article,
            a.prix_article,
            a.type_article,
            a.description_article,
            COUNT(ca.id_article) AS totalVentes
        FROM 
            article a
        JOIN 
            commande_article ca ON a.id_article = ca.id_article
        GROUP BY 
            a.id_article,
            a.nom_article,
            a.photo_article,
            a.prix_article,
            a.type_article,
            a.description_article
        ORDER BY 
            totalVentes DESC
        LIMIT 4"; // Limiter aux 5 articles les plus vendus

    $result = $this->connection->executeQuery($query)->fetchAllAssociative();
    return $result;
}




    #[Route('/backarticle', name: 'app_article_index_back2', methods: ['GET'])]
    public function indexBack(ArticleRepository $articleRepository): Response
    {
        return $this->render('Back/commande/articleCommande.html.twig', [
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
        /** @var UploadedFile $file */
        $file = $form->get('photoArticle')->getData();
        if ($file) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('photos_directory'),
                $fileName
            );

            // Construire l'URL complète de l'image
            $photoArticleFullPath = $request->getSchemeAndHttpHost() . '/img/' . $fileName;

            // Enregistrer l'URL complète dans l'entité
            $article->setPhotoArticle($photoArticleFullPath);

            // Enregistrer l'article dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            // Redirection ou rendu de la page selon votre logique
            return $this->redirectToRoute('app_article_index_back', [
                'photoArticleFullPath' => $photoArticleFullPath,
            ]);
        }
    }

    return $this->render('Back/article/new.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/{idArticle}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('Front/article/show.html.twig', [
            'article' => $article,
        ]);
    }
   
   
    #[Route('/back/{idArticle}', name: 'app_article_show_back', methods: ['GET'])]
    public function showback(Article $article): Response
    {
        return $this->render('Back/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{idArticle}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Gérer le téléchargement de la nouvelle image
        /** @var UploadedFile $file */
        $file = $form->get('photoArticle')->getData();
        if ($file) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('photos_directory'),
                $fileName
            );

            // Construire l'URL complète de la nouvelle image
            $photoArticleFullPath = $request->getSchemeAndHttpHost() . '/img/' . $fileName;

            // Mettre à jour l'URL complète de l'image dans l'entité
            $article->setPhotoArticle($photoArticleFullPath);
        }

        // Enregistrer les modifications dans la base de données
        $entityManager->flush();

        // Redirection ou rendu de la page selon votre logique
        return $this->redirectToRoute('app_article_index_back');
    }

    // Rendre le formulaire d'édition de l'article
    return $this->renderForm('Back/article/edit.html.twig', [
        'article' => $article,
        'form' => $form,
    ]);
}

    
#[Route('/{idArticle}', name: 'app_article_delete', methods: ['POST'])]
public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$article->getIdArticle(), $request->request->get('_token'))) {
        // Supprimer les références de commande_article liées à cet article
        $commandeArticles = $entityManager->getRepository(CommandeArticle::class)->findBy(['idArticle' => $article]);
        foreach ($commandeArticles as $commandeArticle) {
            $entityManager->remove($commandeArticle);
        }

        // Supprimer l'article lui-même
        $entityManager->remove($article);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_article_index_back', [], Response::HTTP_SEE_OTHER);
}





}
