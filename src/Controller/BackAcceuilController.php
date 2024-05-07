<?php

namespace App\Controller;
use App\Entity\Billet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StationRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Station;
use App\Form\StationType;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\billetRepository;
use App\Form\BilletbackType;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Psr\Container\ContainerInterface;

use Dompdf\Dompdf;

class BackAcceuilController extends AbstractController
{
    #[Route('/profileAdmin', name: 'app_profile_admin')]
    public function profile(ContainerInterface $container): Response
    {
        return $this->render('user/profileadmin.html.twig', [
            'controller_name' => 'BackAcceuilController',
            'container' => $container,
        ]);

    }

    #[Route('/back/acceuil', name: 'app_back_acceuil')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackAcceuilController',
        ]);
    }
    #[Route('/billetStation', name: 'app_choose')]
    public function indexxxx(): Response
    {
        return $this->render('back/billetStation.html.twig', [
            'controller_name' => 'BackAcceuilController',
        ]);
    }
    #[Route('/back/acceuil/dashboard', name: 'app_dashboard')]
    public function pieChart(billetRepository $billetRepository): Response
    {
        $pricesByStation = $billetRepository->getPricesByStation();
        
        // Préparer les données pour le piechart des prix par station
        $data1 = [];
        foreach ($pricesByStation as $result) {
            $data1[] = [
                'nom' => $result['nom'],
                'adresse' => $result['adresse'],
                'type' => $result['type'],
                'totalPrice' => $result['totalPrice']
            ];
        }
    
        // Préparer les données pour le deuxième piechart (s'il est nécessaire)
        $destinations = $billetRepository->getDestinationsByStation();

        $data2 = [];
        $totalBillets = 0; // Variable pour stocker le nombre total de billets
        
        // Calculer le nombre total de billets
        foreach ($destinations as $destination) {
            $totalBillets += $destination['count'];
        }
        
        // Préparer les données pour chaque station
        foreach ($destinations as $destination) {
            $count = $destination['count']; // Nombre de billets associés à la station
        
            // Calculer le pourcentage de billets pour cette station
            $pourcentage = ($count / $totalBillets) * 100;
        
            // Ajouter le pourcentage au tableau de données
            $data2[] = [$destination['adresse'], $pourcentage];
        }
        
        // Retourner la réponse avec toutes les données nécessaires
        return $this->render('back/dashboard.html.twig', [
            'data1' => $data1,
            'data2' => $data2
        ]);
    }
    
    
    
    
    #[Route('/transportback', name: 'transport_back')]
    public function indexxx(Request $req,ManagerRegistry $Manager, StationRepository $repo,PaginatorInterface $paginator): Response
    {  $entityManager = $Manager->getManager();
        $list = $repo->findAll();
        $list = $paginator->paginate(
            $list, /* query NOT result */
            $req->query->getInt('page', 1),
            3
        );
        $station = new Station();
        $form = $this->createForm(StationType::class, $station);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si une station avec le même nom, la même adresse et le même type existe déjà
            $existingStation = $repo->findOneBy([
                'nomStation' => $station->getNomStation(),
                'adressStation' => $station->getAdressStation(),
                'type' => $station->getType()
            ]);
            
            if ($existingStation) {
                $this->addFlash('error', 'Une station avec le même nom, adresse et type existe déjà.');
            } else {
                // Aucune station avec le même nom, adresse et type n'existe, ajouter la nouvelle station
                $entityManager->persist($station);
                $entityManager->flush();
                $this->addFlash('success', 'La station a été ajoutée avec succès.');
            }
            
            return $this->redirectToRoute('transport_back');
        }
        
        return $this->render('back/transportback.html.twig', [
            'f' => $form->createView(),
            'list' => $list
        ]);
    }
    #[Route('/appliquer_promo', name: 'appliquer_promo')] 
    public function appliquerPromo(ManagerRegistry $manager, SessionInterface $session): Response
    {
        $em = $manager->getManager();
        $billets = $em->getRepository(Billet::class)->findAll();
    
        // Récupérer les IDs des billets sur lesquels la promotion a déjà été appliquée
        $billetsWithPromoApplied = $session->get('billetsWithPromoApplied', []);
    
        // Appliquer la promotion à tous les billets
        foreach ($billets as $billet) {
            // Vérifier si la promotion a déjà été appliquée à ce billet
            if (!in_array($billet->getRefVoyage(), $billetsWithPromoApplied)) {
                // Modifier le prix selon la promotion
                $nouveauPrix = $billet->getPrix() * 0.5; // Exemple de réduction de 50%
                $billet->setPrix($nouveauPrix);
                $em->persist($billet);
                
                // Enregistrer l'ID du billet dans la session pour indiquer que la promotion a été appliquée à ce billet
                $billetsWithPromoApplied[] = $billet->getRefVoyage();
            }
        }
        $em->flush();
    
        // Enregistrer les IDs des billets sur lesquels la promotion a été appliquée dans la session
        $session->set('billetsWithPromoApplied', $billetsWithPromoApplied);
    
        return $this->redirectToRoute('app_billet');
    }
    
        
    
    #[Route('/EditStation/{id}', name: 'edit_station')] 
    public function editstation (Request $req,ManagerRegistry $Manager,StationRepository $repo,$id,PaginatorInterface $paginator)
    :Response {
        $em=$Manager->getManager();
        $station=$repo->find($id);
        $form=$this->createForm(StationType::class,$station);
        $form->handleRequest($req);
        if ($form ->isSubmitted())
        {
        $em->persist($station);
        $em->flush();
       
        return $this->redirectToRoute('transport_back');
        }
        else {
            $list = $repo->findAll();
            $list = $paginator->paginate(
                $list, /* query NOT result */
                $req->query->getInt('page', 1),
                3
            );
        return $this->renderForm('back/transportback.html.twig',
        ['f'=>$form,
        'list' => $list
        ]
    );
    }}
    #[Route('/Deletestation{id}', name: 'delete_station')]
    public function deletestation(ManagerRegistry $Manager, StationRepository $repo, $id): Response
    {
        $em = $Manager->getManager();
        $station = $repo->find($id);
    
        if (!$station) {
            // Handle case when station with given ID is not found
            throw $this->createNotFoundException('Station not found');
        }
    
        try {
            $em->remove($station);
            $em->flush();
        } catch (ForeignKeyConstraintViolationException $e) {
            // Handle foreign key constraint violation gracefully
            // Redirect with an error message or handle it appropriately
            return $this->redirectToRoute('transport_back', ['error' => 'Cannot delete the station due to related records']);
        }
    
        // Redirect to the desired route after successful deletion
        return $this->redirectToRoute('transport_back');
    }
   #[Route('/billetback', name: 'app_billet')]
public function ajouterbillet(Request $req, ManagerRegistry $Manager, billetRepository $repo,UserRepository $us, PaginatorInterface $paginator, SessionInterface $session): Response
{
    $em = $Manager->getManager();
    $billet = new billet();
    $form = $this->createForm(BilletbackType::class, $billet);
    $form->handleRequest($req);

    if ($form->isSubmitted() && $form->isValid()) {
        $billet->setIdPersonne($us->find(65));
        $em->persist($billet);
        $em->flush();
        
        // Mettre à jour l'état de la promotion dans la session pour indiquer qu'elle a été appliquée sur ce nouveau billet
        $session->set('promoApplied', false);

        return $this->redirectToRoute('app_billet');
    }

    // Récupérer les billets non paginés
    $nonPaginatedList = $repo->findAll();

    // Paginer les résultats
    $paginatedList = $paginator->paginate(
        $nonPaginatedList, /* query NOT result */
        $req->query->getInt('page', 1),
        3
    );

    return $this->render('back/billetback.html.twig', [
        'f' => $form->createView(),
        'list' => $paginatedList // Utiliser la variable paginée ici
    ]);
}

#[Route('/save-promo-state', name:'save_promo_state', methods: ['POST'])]
public function savePromoState(Request $request): JsonResponse
{
    // Récupérer les données JSON de la requête
    $data = json_decode($request->getContent(), true);

    // Vérifier si l'état de la promotion est défini dans les données
    $promoApplied = $data['promoApplied'] ?? false;

    // Mettre à jour l'état de la promotion dans la session
    $request->getSession()->set('promoApplied', $promoApplied);

    // Répondre avec un message JSON
    return new JsonResponse(['message' => 'Promotion state updated']);
}

#[Route('/EditBilletback/{id}', name: 'edit_billetBack')] 
public function editBillet (Request $req,ManagerRegistry $Manager,billetRepository $repo,$id,PaginatorInterface $paginator)
:Response {
    $em=$Manager->getManager();
    $billet=$repo->find($id);
    $form=$this->createForm(BilletbackType::class,$billet);
    $form->handleRequest($req);
    if ($form ->isSubmitted())
    {
    $em->persist($billet);
    $em->flush();
   
    return $this->redirectToRoute('app_billet');
    }
    else {
       
        $nonPaginatedList = $repo->findAll();

        // Paginer les résultats
        $paginatedList = $paginator->paginate(
            $nonPaginatedList, /* query NOT result */
            $req->query->getInt('page', 1),
            3
        );
    return $this->renderForm('back/billetback.html.twig',
    ['f'=>$form,
    'list' => $paginatedList
    ]
);
}}
#[Route('/deleteBilletback/{id}', name: 'delete_billetBack')]
public function deleteBillet(ManagerRegistry $manager, BilletRepository $repo, $id): Response
{
    $em = $manager->getManager();
    $billet = $repo->find($id);

    // Vérifier si l'entité de billet a été trouvée
    if (!$billet) {
        // Si l'entité n'est pas trouvée, rediriger ou afficher un message d'erreur
        // Par exemple :
         return $this->redirectToRoute('app_billet');
        // ou
        // throw $this->createNotFoundException('Billet non trouvé');
    }

    // Si l'entité est trouvée, la supprimer
    $em->remove($billet);
    $em->flush();

    // Rediriger vers la page des billets après la suppression
    return $this->redirectToRoute('app_billet');
}
#[Route('/generate/pdf', name: 'Extract_data', methods: ['GET' , 'POST'])]
    public function generatePdf(billetRepository $bil): Response
    { 
     
        $billets = $bil->findAll();
        $currentDate = new \DateTime();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $html = $this->renderView('back/pdf.html.twig', ['billets' => $billets , 'date' => $currentDate]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();  
        $pdfContent = $dompdf->output();
        $response = new Response();
        $response->setContent($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
    
       
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'les_billets.pdf'
        );
        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }

}
