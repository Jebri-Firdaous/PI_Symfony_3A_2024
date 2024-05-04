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
use Doctrine\DBAL\Connection;
use Knp\Snappy\Pdf;
use Doctrine\ORM\Query\Expr\Func;
use Knp\Component\Pager\PaginatorInterface;




#[Route('/commande')]
class CommandeController extends AbstractController
{

  
    private $paginator;

    
    public function __construct(private Connection $connection, PaginatorInterface $paginator) {
        $this->paginator = $paginator;
    }
    #[Route('/stats', name: 'app_commande_stats', methods: ['GET'])]
    public function stats(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les statistiques sur les commandes
        $commandesStats = $this->getCommandesStats($entityManager);

        // Récupérer les statistiques sur les articles les plus vendus
        $articlesStats = $this->getArticlesStats();

        $topArticleOfWeek = $this->getTopArticleOfWeek();
        $commandesParJour = $this->getCommandesParJour($entityManager);
       

        return $this->render('Back/commande/stats.html.twig', [
            'commandesStats' => $commandesStats,
            'articlesStats' => $articlesStats,
            'topArticleOfWeek' => $topArticleOfWeek,
            'commandesParJour' => $commandesParJour,
        ]);
    }

    private function getTopArticleOfWeek(): array
{
    // Ajoutez votre logique pour récupérer l'article le plus vendu de la semaine avec le plus grand prix total ici
    // Par exemple, vous pourriez utiliser une requête SQL pour le faire

    return [
        'nom_article' => 'Nom de l\'article',
        'totalVentes' => 10, // Exemple de nombre de ventes
        'prixTotal' => 500, // Exemple de prix total
    ];
}
private function getCommandesStats(EntityManagerInterface $entityManager): array
{
    $query = "SELECT COUNT(c.idCommande) AS totalCommandes, MAX(c.prixTotale) AS prixTotalMax FROM App\Entity\Commande c";
    $result = $entityManager->createQuery($query)->getSingleResult();
    $result['totalArticles'] = $this->getTotalArticles($entityManager); 
    $result['totalCommandes'] = $this->getTotalCommandes($entityManager); // Appel à une méthode pour obtenir le total d'articles
    return $result;
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
    private function getCommandesParJour(EntityManagerInterface $entityManager): array
{
    $queryBuilder = $entityManager->createQueryBuilder();

    $queryBuilder->select('SUBSTRING(c.delaisCommande, 1, 10) AS dateCommande, COUNT(c.idCommande) AS totalCommandes')
        ->from(Commande::class, 'c')
        ->groupBy('dateCommande');

    $query = $queryBuilder->getQuery();
    $result = $query->getResult();

    // Ajuster les dates pour supprimer 2 jours
    foreach ($result as &$item) {
        $item['dateCommande'] = date('Y-m-d', strtotime($item['dateCommande'] . ' -2 days'));
    }

    return $result;
}
private function getTotalArticles(): int
{
    $query = "SELECT COUNT(*) AS totalArticles FROM article";
    $result = $this->connection->executeQuery($query)->fetchOne();
    return $result;
}
private function getTotalCommandes(): int
{
    $query = "SELECT COUNT(*) AS totalCommandes FROM commande";
    $result = $this->connection->executeQuery($query)->fetchOne();
    return $result;
}
    
    
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('Front/commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }
    #[Route('/back', name: 'app_commande_index_back', methods: ['GET'])]
public function indexBack(CommandeRepository $commandeRepository, Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
{
  
    // Récupérer toutes les commandes avec une requête de base
    $commandesQuery = $commandeRepository->createQueryBuilder('c')
        ->getQuery();

    // Paginer les commandes
    $commandes = $paginator->paginate(
        $commandesQuery, // Requête à paginer
        $request->query->getInt('page', 1), // Numéro de page par défaut
        4 // Limiter à 8 commandes par page
    );
     // Récupérer le numéro de page actuel
     $currentPage = $request->query->getInt('page', 1);
     $totalCommandesCount = $commandeRepository->createQueryBuilder('c')->select('COUNT(c.idCommande)')->getQuery()->getSingleScalarResult();
     $maxPage = ceil($totalCommandesCount / 2); // 2 commandes par page

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
        'page' => $currentPage, // Ajouter la variable 'page' au contexte
        'maxPage' => $maxPage, // Ajouter la variable 'maxPage' au contexte
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

#[Route('/download-pdf/{idCommande}', name: 'download_pdf')]
public function downloadPdf(Commande $commande, EntityManagerInterface $entityManager, Pdf $knpSnappyPdf): Response
{
    $articlesParCommande = [];
    // Récupérer les articles associés à chaque commande
    $commandeArticles = $entityManager->getRepository(CommandeArticle::class)->findBy(['idCommande' => $commande->getIdCommande()]);
        $articles = [];
        foreach ($commandeArticles as $commandeArticle) {
            $articles[] = $commandeArticle->getIdArticle();
        }
        $articlesParCommande[$commande->getIdCommande()] = $articles;

    // Générer le contenu HTML du PDF
    $invoiceHtml = $this->renderView('Front/commande/pdf_template.html.twig', [
        'commande' => $commande,
        'articlesParCommande' => $articlesParCommande,
    ]);

    // Générer le PDF à partir du contenu HTML
    $pdf = $knpSnappyPdf->getOutputFromHtml($invoiceHtml);

    // Créer une réponse pour le PDF à télécharger
    $response = new Response($pdf);
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="commande_'.$commande->getIdCommande().'.pdf"');

    return $response;
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

            return $this->redirectToRoute('app_commande_index_back', [], Response::HTTP_SEE_OTHER);
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
