<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Repository\HotelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Hotel;
use App\Form\HotelReservationType;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints as Assert;
#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/listReservation', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('Front/reservation/index.html.twig', [
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
     $idHotel = $request->get('idHotel');
     $hotel = $entityManager->getRepository(Hotel::class)->find($idHotel);
     
     //dd($hotel);
     $hotelChoices = [];
    //  foreach ($hotels as $hotel) {
    //      $hotelChoices[$hotel->getNomHotel()] = $hotel;
    //  }
     
     // Sérialiser les prix des hôtels en JSON pour les passer à la vue
     $selectedHotelNames = array_keys($hotelChoices);
 
     $reservation = new Reservation();

     $form = $this->createForm(HotelReservationType::class, $reservation, [
         'hotel' => $hotel
     ]);
     
     $form->handleRequest($request);
     
     if ($form->isSubmitted() && $form->isValid()) {
         $reservation->setIdHotel($hotel);

         
         $entityManager->persist($reservation);
         $entityManager->flush();
         
         return $this->redirectToRoute('app_reservation_index');
     }
     
     return $this->render('Front/reservation/addReservation.html.twig', [
         'form' => $form->createView(),
         'hotel' => $hotel,
         'prices' => [
            'normal' => $hotel->getPrix1(),
            'standard' => $hotel->getPrix2(),
            'luxe' => $hotel->getPrix3()
         ]
     ]);
 }



/*
#[Route('/addReservation/{idHotel}', name: 'app_tourisme')]
public function tourismeHome(Request $request, EntityManagerInterface $entityManager, HotelRepository $hotelRepository, $idHotel): Response
{

 

    // Récupérer le nom de l'hôtel en appelant la méthode getHotelName du contrôleur HotelController
    $hotelNameResponse = $this->forward('App\Controller\HotelController::getHotelName', ['id' => $idHotel]);
    $hotelName = $hotelNameResponse->getContent();


   
    
    // Créer une nouvelle instance de l'entité Reservation
    $reservation = new Reservation();

    // Créer le formulaire en passant l'entité Reservation et le nom de l'hôtel
    $form = $this->createForm(HotelReservationType::class, $reservation, [
        'hotelName' => $hotelName,
    ]);

    // Gérer la soumission du formulaire
    $form->handleRequest($request);

    // Vérifier si le formulaire a été soumis et est valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Sauvegarder la réservation en base de données
        $entityManager->persist($reservation);
        $entityManager->flush();

        // Rediriger vers la page d'accueil des réservations
        return $this->redirectToRoute('app_reservation_index');
    }

    // Rendre le modèle Twig en passant la variable form
    return $this->render('reservation/addReservation.html.twig', [
        'form' => $form->createView(),
    ]);
}
*/



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
 

 #[Route('/reservation/{refReservation}', name: 'app_reservation_show_front', methods: ['GET'])]
 public function showFront(Reservation $reservation): Response

   
    {
        // Retrieve the associated hotel
        $hotel = $reservation->getIdHotel();
        
        // Get the hotel name or set a default value if the hotel is not set
        $hotelName = $hotel ? $hotel->getNomHotel() : 'Unknown Hotel';

        return $this->render('Front/reservation/show.html.twig', [
            'reservation' => $reservation,
            'hotelName' => $hotelName,
        ]);
    }
    

    #[Route('/{refReservation}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        
        $hotel = $entityManager->getRepository(Hotel::class)->find($reservation->getIdHotel());
        $hotelChoices = [];
       
        
        // Sérialiser les prix des hôtels en JSON pour les passer à la vue
    
        $form = $this->createForm(HotelReservationType::class, $reservation, [
            'hotel' => $hotel
        ]);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('Front/reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'hotel' => $hotel, // Passer les prix à la vue
            'prices' => [
                'normal' => $hotel->getPrix1(),
                'standard' => $hotel->getPrix2(),
                'luxe' => $hotel->getPrix3()
             ]
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

#[Route('/{refReservation}/deleate', name: 'app_reservation_delete')]
public function delete($refReservation, ManagerRegistry $manager, ReservationRepository $reservationrepository): Response
{
    $em = $manager->getManager();
    $reservation = $reservationrepository->find($refReservation);
  
        $em->remove($reservation);
        $em->flush();
  
       
    
    return $this->redirectToRoute('app_reservation_index');
}




//////////////////////****BAck ****//////////////////////////




#[Route('/listReservationBack', name: 'app_reservation_index_back', methods: ['GET'])]
public function indexBack(ReservationRepository $reservationRepository): Response
{
    return $this->render('Back/reservation/index.html.twig', [
        'reservations' => $reservationRepository->findAll(),
    ]);
}

#[Route('/addReservationBack', name: 'app_tourisme_back')]
public function tourismeBack(Request $request, EntityManagerInterface $entityManager): Response
{
    $hotels = $entityManager->getRepository(Hotel::class)->findAll();
    
    $hotelChoices = [];
    foreach ($hotels as $hotel) {
        $hotelChoices[$hotel->getNomHotel()] = $hotel;
    }
    
    // Sérialiser les prix des hôtels en JSON pour les passer à la vue
    $selectedHotelNames = array_keys($hotelChoices);

    $reservation = new Reservation();
    $form = $this->createForm(ReservationType::class, $reservation, [
        'hotelChoices' => $hotelChoices,
    ]);
    
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        

        
        $entityManager->persist($reservation);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_reservation_index_back');
    }
    
    return $this->render('Back/reservation/addReservation.html.twig', [
        'form' => $form->createView(),
        'selectedHotelNames' => $selectedHotelNames,
        'prices' => [
            'normal' => $hotel->getPrix1(),
            'standard' => $hotel->getPrix2(),
            'luxe' => $hotel->getPrix3()
         ]
    ]);
}
#[Route('/admin/reservation/{refReservation}', name: 'app_reservation_show_back', methods: ['GET'])]
public function showBack(Reservation $reservation): Response


{
    // Retrieve the associated hotel
    $hotel = $reservation->getIdHotel();
    
    // Get the hotel name or set a default value if the hotel is not set
    $hotelName = $hotel ? $hotel->getNomHotel() : 'Unknown Hotel';

    return $this->render('Back/reservation/show.html.twig', [
        'reservation' => $reservation,
        'hotelName' => $hotelName,
    ]);
}

#[Route('/{refReservation}/editBack', name: 'app_reservation_edit_back', methods: ['GET', 'POST'])]
public function editBack(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
{
    $hotels = $entityManager->getRepository(Hotel::class)->findAll();
    
    $hotelChoices = [];
    foreach ($hotels as $hotel) {
        $hotelChoices[$hotel->getNomHotel()] = $hotel;
    }
    
    // Sérialiser les prix des hôtels en JSON pour les passer à la vue
    $selectedHotelNames = array_keys($hotelChoices);

    $form = $this->createForm(ReservationType::class, $reservation, [
        'hotelChoices' => $hotelChoices,
    ]);
    
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_reservation_index_back', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Back/reservation/edit.html.twig', [
        'reservation' => $reservation,
        'form' => $form,
        'selectedHotelNames' => $selectedHotelNames,
        'prices' => [
            'normal' => $hotel->getPrix1(),
            'standard' => $hotel->getPrix2(),
            'luxe' => $hotel->getPrix3()
         ]
   
    ]);
}




#[Route('/admin/{refReservation}/deleateBack', name: 'app_reservation_delete_back')]
public function deleteBack($refReservation, ManagerRegistry $manager, ReservationRepository $reservationrepository): Response
{
    $em = $manager->getManager();
    $reservation = $reservationrepository->find($refReservation);
  
        $em->remove($reservation);
        $em->flush();
  
       
    
    return $this->redirectToRoute('app_reservation_index_back');
}


}