<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\HotelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Hotel;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/listReservation', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

 /*   
    #[Route('/addReservation', name: 'app_tourisme')]
  
    public function tourismeHome(Request $request, EntityManagerInterface $entityManager): Response
{
    // Récupérer tous les hôtels depuis la base de données
    $hotels = $entityManager->getRepository(Hotel::class)->findAll();

    // Créer un tableau associatif des hôtels avec le nom de l'hôtel comme clé et l'objet Hotel comme valeur
    $hotelChoices = [];
    foreach ($hotels as $hotel) {
        $hotelChoices[$hotel->getNomHotel()] = $hotel;
    }

   

    // Créer une nouvelle instance de l'entité Reservation
    $reservation = new Reservation();

    // Créer le formulaire en utilisant ReservationType et lier l'entité Reservation
    $form = $this->createForm(ReservationType::class, $reservation, [
        'hotelChoices' => $hotelChoices, // Passer les choix d'hôtels au formulaire
    ]);

    // Gérer la soumission du formulaire
    $form->handleRequest($request);

    // Vérifier si le formulaire est soumis et valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Persistez l'entité Reservation dans la base de données
        $entityManager->persist($reservation);
        $entityManager->flush();

        // Redirection ou autre traitement après l'ajout réussi
        return $this->redirectToRoute('app_reservation_index');
    }

    // Afficher le formulaire dans le template Twig
    return $this->render('reservation/addReservation.html.twig', [
        'form' => $form->createView(),
    ]);
}

 */   
    
 /*#[Route('/addReservation', name: 'app_tourisme')]
 public function tourismeHome(Request $request, EntityManagerInterface $entityManager): Response
 {
     $hotels = $entityManager->getRepository(Hotel::class)->findAll();
     
     $hotelChoices = [];
     foreach ($hotels as $hotel) {
         $hotelChoices[$hotel->getNomHotel()] = $hotel;
     }
     
     $selectedHotelNames = array_keys($hotelChoices);
     $hotelPrices = $this->getHotelPrices($selectedHotelNames, $entityManager);
     



     $reservation = new Reservation();
     $form = $this->createForm(ReservationType::class, $reservation, [
        'hotelChoices' => $hotelChoices,
        'hotelPrices' => $hotelPrices, // Passer les prix au formulaire
    ]);
     
     $form->handleRequest($request);
     
     if ($form->isSubmitted() && $form->isValid()) {
         $nomHotel = $reservation->getIdHotel()->getNomHotel();
         $typeChambre = $reservation->getTypeChambre();
         $prixReservation = null;
         
         if ($nomHotel && isset($hotelPrices[$nomHotel])) {
             switch ($typeChambre) {
                 case 'normal':
                     $prixReservation = $hotelPrices[$nomHotel]['prix1'];
                     break;
                 case 'standard':
                     $prixReservation = $hotelPrices[$nomHotel]['prix2'];
                     break;
                 case 'luxe':
                     $prixReservation = $hotelPrices[$nomHotel]['prix3'];
                     break;
             }
         }
         
         $reservation->setPrixReservation($prixReservation);
         $entityManager->persist($reservation);
         $entityManager->flush();
         
         return $this->redirectToRoute('app_reservation_index');
     }
     
    return $this->render('reservation/addReservation.html.twig', [
    'form' => $form->createView(),
    'hotelPrices' => $hotelPrices,
    'selectedHotelNames' => $selectedHotelNames,
]);
 }
 */



 #[Route('/addReservation', name: 'app_tourisme')]
 public function tourismeHome(Request $request, EntityManagerInterface $entityManager): Response
 {
     $hotels = $entityManager->getRepository(Hotel::class)->findAll();
     
     $hotelChoices = [];
     foreach ($hotels as $hotel) {
         $hotelChoices[$hotel->getNomHotel()] = $hotel;
     }
     
     // Sérialiser les prix des hôtels en JSON pour les passer à la vue
     $selectedHotelNames = array_keys($hotelChoices);
     $hotelPrices = $this->getHotelPrices($selectedHotelNames, $entityManager);
     $serializedHotelPrices = json_encode($hotelPrices);
 
     $reservation = new Reservation();
     $form = $this->createForm(ReservationType::class, $reservation, [
         'hotelChoices' => $hotelChoices,
         'hotelPrices' => $serializedHotelPrices, // Passer les prix au formulaire
     ]);
     
     $form->handleRequest($request);
     
     if ($form->isSubmitted() && $form->isValid()) {
         $nomHotel = $reservation->getIdHotel()->getNomHotel();
         $typeChambre = $reservation->getTypeChambre();
         $prixReservation = null;
         
         if ($nomHotel && isset($hotelPrices[$nomHotel])) {
             switch ($typeChambre) {
                 case 'normal':
                     $prixReservation = $hotelPrices[$nomHotel]['prix1'];
                     break;
                 case 'standard':
                     $prixReservation = $hotelPrices[$nomHotel]['prix2'];
                     break;
                 case 'luxe':
                     $prixReservation = $hotelPrices[$nomHotel]['prix3'];
                     break;
             }
         }
         
         $reservation->setPrixReservation($prixReservation);
         $entityManager->persist($reservation);
         $entityManager->flush();
         
         return $this->redirectToRoute('app_reservation_index');
     }
     
     return $this->render('reservation/addReservation.html.twig', [
         'form' => $form->createView(),
         'hotelPrices' => $serializedHotelPrices, // Passer les prix à la vue
         'selectedHotelNames' => $selectedHotelNames,
     ]);
 }
 
 private function getHotelPrices(array $selectedHotelNames, EntityManagerInterface $entityManager): array
 {
     $hotelPrices = [];
     
     foreach ($selectedHotelNames as $nomHotel) {
         $hotel = $entityManager->getRepository(Hotel::class)->findOneBy(['nomHotel' => $nomHotel]);
 
         if ($hotel) {
             $hotelPrices[$nomHotel] = [
                 'prix1' => $hotel->getPrix1(),
                 'prix2' => $hotel->getPrix2(),
                 'prix3' => $hotel->getPrix3(),
             ];
         }
     }
     
     return $hotelPrices;
 }
 



    #[Route('/{refReservation}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        // Retrieve the associated hotel
        $hotel = $reservation->getIdHotel();
        
        // Get the hotel name or set a default value if the hotel is not set
        $hotelName = $hotel ? $hotel->getNomHotel() : 'Unknown Hotel';

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'hotelName' => $hotelName,
        ]);
    }

    #[Route('/{refReservation}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $hotels = $entityManager->getRepository(Hotel::class)->findAll();
        
        $hotelChoices = [];
        foreach ($hotels as $hotel) {
            $hotelChoices[$hotel->getNomHotel()] = $hotel;
        }
        
        // Sérialiser les prix des hôtels en JSON pour les passer à la vue
        $selectedHotelNames = array_keys($hotelChoices);
        $hotelPrices = $this->getHotelPrices($selectedHotelNames, $entityManager);
        $serializedHotelPrices = json_encode($hotelPrices);
    
        $form = $this->createForm(ReservationType::class, $reservation, [
            'hotelChoices' => $hotelChoices,
            'hotelPrices' => $serializedHotelPrices, // Passer les prix au formulaire
        ]);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'hotelPrices' => $serializedHotelPrices, // Passer les prix à la vue
            'selectedHotelNames' => $selectedHotelNames,
        ]);
    }
    /*

    #[Route('/{refReservation}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getRefReservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }


*/

#[Route('/{refReservation}', name: 'app_reservation_delete')]
public function deleteAuthor($refReservation, ManagerRegistry $manager, ReservationRepository $reservationrepository): Response
{
    $em = $manager->getManager();
    $author = $reservationrepository->find($refReservation);
  
        $em->remove($author);
        $em->flush();
  
       
    
    return $this->redirectToRoute('app_reservation_index');
}


}