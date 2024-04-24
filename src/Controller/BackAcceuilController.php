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
use App\Repository\billetRepository;
use App\Form\BilletbackType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
class BackAcceuilController extends AbstractController
{
    #[Route('/back/acceuil', name: 'app_back_acceuil')]
    public function index(): Response
    {
        return $this->render('back/indexBack.html.twig', [
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

    #[Route('/transportback', name: 'transport_back')]
    public function indexxx(Request $req,ManagerRegistry $Manager,StationRepository $repo): Response
    {  $entityManager = $Manager->getManager();
        $list = $repo->findAll();
        
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
    public function appliquerPromo(ManagerRegistry $manager): Response
    {
        $em = $manager->getManager();
        $billets = $em->getRepository(Billet::class)->findAll();

        // Appliquer la promotion à tous les billets
        foreach ($billets as $billet) {
            // Modifier le prix selon la promotion
            $nouveauPrix = $billet->getPrix() * 0.5; // Exemple de réduction de 20%
            $billet->setPrix($nouveauPrix);
            $em->persist($billet);
        }
        $em->flush();

        // Rediriger ou afficher un message de succès
        return $this->redirectToRoute('app_billet');
    }
    #[Route('/EditStation/{id}', name: 'edit_station')] 
    public function editstation (Request $req,ManagerRegistry $Manager,StationRepository $repo,$id)
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
public function ajouterbillet(Request $req,ManagerRegistry $Manager,billetRepository $repo): Response
{   $em=$Manager->getManager();
    $list=$repo->findAll();
    $billet=new billet();
    $form=$this->createForm(BilletbackType::class,$billet);
    $form->handleRequest($req);
  
    if ($form ->isSubmitted() && $form ->isValid())
    {
    $em->persist($billet);
    $em->flush();
  
    return $this->redirectToRoute('app_billet');
    }
    
    else {
        $list = $repo->findAll();
    return $this->render('back/billetback.html.twig', [
        'f'=>$form->createView(),
        'list' => $list
    ]);
}}
#[Route('/EditBilletback/{id}', name: 'edit_billetBack')] 
public function editBillet (Request $req,ManagerRegistry $Manager,billetRepository $repo,$id)
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
        $list = $repo->findAll();
    return $this->renderForm('back/billetback.html.twig',
    ['f'=>$form,
    'list' => $list
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

}
