<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\QrCodeService;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/hotel')]
class HotelController extends AbstractController
{
    private $qrcodeService;

    public function __construct(QrCodeService $qrcodeService)
    {
        $this->qrcodeService = $qrcodeService;
       
    }
 

    #[Route('/listHotel', name: 'app_hotel_index', methods: ['GET'])]
    public function index(Request $request , HotelRepository $hotelRepository, PaginatorInterface $paginator): Response
    {    
        
     // Récupérer les statistiques sur les articles les plus vendus

   

     
        $hotels = $hotelRepository->findAll();

        $qrCodes = [];
        foreach ($hotels as $hotel) {
            // Générer le QR code pour chaque hotel
            $qrCodePath = $this->qrcodeService->qrcode($hotel);
            $qrCodes[$hotel->getIdHotel()] = $qrCodePath; // Utilisez l'ID de l'hotel comme clé du tableau
        }

    ////////////////////////////*******************pagination***************///////////////////////////////////////
    
    $pagination = $paginator->paginate(
    $hotels,
    $request->query->getInt('page', 1), // Current page number
    3 // Number of items per page
);
        return $this->render('Back/hotel/index.html.twig', [
            'hotels' => $hotelRepository->findAll(),
            'qrCodes' => $qrCodes,
            'hotels' => $pagination,
        ]);
    }

   

    #[Route('/listHotelFront', name: 'app_hotel_index_Front', methods: ['GET'])]
    public function indexFront(Request $request, HotelRepository $hotelRepository, PaginatorInterface $paginator, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les statistiques sur les hôtels les plus réservés
        $hotelsStats = $entityManager->createQueryBuilder()
            ->select('h.idHotel, h.nomHotel, h.adressHotel, h.prix1, h.prix2, h.prix3, COUNT(r.refReservation) AS totalReservations')
            ->from('App\Entity\Hotel', 'h')
            ->leftJoin('App\Entity\Reservation', 'r', 'WITH', 'r.idHotel = h.idHotel')
            ->groupBy('h.idHotel, h.nomHotel, h.adressHotel, h.prix1, h.prix2, h.prix3')
            ->orderBy('totalReservations', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    
        // Récupérer tous les hôtels
        $hotels = $hotelRepository->findAll();
    
        // Générer les QR codes pour chaque hôtel
        $qrCodes = [];
        foreach ($hotels as $hotel) {
            $qrCodePath = $this->qrcodeService->qrcode($hotel);
            $qrCodes[$hotel->getIdHotel()] = $qrCodePath;
        }
    
        // Pagination des hôtels
        $pagination = $paginator->paginate(
            $hotels,
            $request->query->getInt('page', 1), // Numéro de page actuel
            3 // Nombre d'éléments par page
        );
    
        return $this->render('Front/hotel/index.html.twig', [
            'hotels' => $pagination,
            'qrCodes' => $qrCodes,
            'hotelsStats' => $hotelsStats,
        ]);
    }
    

#[Route('/getHotelName/{id}', name: 'app_get_hotel_name', methods: ['GET'])]
public function getHotelName($id, HotelRepository $hotelRepository): Response
{
    $hotel = $hotelRepository->find($id);
    if (!$hotel) {
        throw $this->createNotFoundException('Hotel not found');
    }

    $hotelName = $hotel->getNomHotel();

    // Retourner le nom de l'hôtel sous forme de réponse JSON
    return new JsonResponse(['hotelName' => $hotelName]);
}



    #[Route('/addHotel', name: 'app_hotel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hotel);
            $entityManager->flush();

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/hotel/addHotel.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
        ]);
    }

    #[Route('/{idHotel}', name: 'app_hotel_show', methods: ['GET'])]
    public function show(Hotel $hotel): Response
    {
        return $this->render('Back/hotel/show.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    #[Route('/{idHotel}/edit', name: 'app_hotel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/hotel/edit.html.twig', [
            'hotel' => $hotel,
            'form' => $form,
        ]);
    }

  /*  #[Route('/{idHotel}', name: 'app_hotel_delete', methods: ['POST'])]
    public function delete(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getIdHotel(), $request->request->get('_token'))) {
            $entityManager->remove($hotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hotel_index', [], Response::HTTP_SEE_OTHER);
    }
*/

#[Route('/admin/{idHotel}/deleateBack', name: 'app_hotel_delete')]
public function delete($idHotel, ManagerRegistry $manager, HotelRepository $hotelrepository): Response
{
    $em = $manager->getManager();
    $hotel = $hotelrepository->find($idHotel);
  
        $em->remove($hotel);
        $em->flush();
  
       
    
    return $this->redirectToRoute('app_hotel_index');
}



#[Route('/search', name: 'app_hotel_search', methods: ['GET'])]
public function search(Request $request, HotelRepository $HotelRepository): JsonResponse
{
    $query = $request->query->get('q');
    $results = $HotelRepository->findBySearchQuery($query); // Implement findBySearchQuery method in your repository

    $formattedResults = [];
    foreach ($results as $result) {
        // Format results as needed
        $formattedResults[] = [
            'idHotel' => $result->getIdHotel(),
            'nomHotel' => $result->getNomHotel(),
            'adressHotel' => $result->getAdressHotel(),
            'prix1' => $result->getPrix1(),
            'prix2' => $result->getPrix2(),
            'prix3' => $result->getPrix3(),
            'numero1' => $result->getNumero1(),
            'numero2' => $result->getNumero2(),
            'numero3' => $result->getNumero3(),


            // Add other fields as needed
        ];
    }

    return new JsonResponse($formattedResults);
}


#[Route('/trieasc', name: 'app_hotel_trieasc', methods: ['GET'])]
public function ascendingAction(HotelRepository $hotelRepository)
{
   return $this->render('Back/hotel/index.html.twig', [
       'hotels' => $hotelRepository->findAllAscending("h.prix1"),
   ]);
}

#[Route('/triedesc', name: 'app_hotel_triedesc', methods: ['GET'])]
public function descendingAction(HotelRepository $hotelRepository)
{
  
   return $this->render('Back/hotel/index.html.twig', [
       'hotels' => $hotelRepository->findAllDescending("h.prix1"),
   ]);

}
    /*

        #[Route('/{idHotel}', name: 'app_hotel_delete', methods: ['POST'])]
    public function delete($idHotel ,ManagerRegistry $manager , Request $request,HotelRepository $hotelrepository): Response
    {
        $em = $manager->getManager();
        $hotel = $hotelrepository->find($idHotel);

        $em->remove($hotel);
        $em->flush();
        

        return $this->redirectToRoute('app_hotel_index');
    }

    */ 

/***************************************Front****************************************/





/*
#[Route('/addHotelFront', name: 'app_hotel_new_Front', methods: ['GET', 'POST'])]
public function newFront(Request $request, EntityManagerInterface $entityManager): Response
{
    $hotel = new Hotel();
    $form = $this->createForm(HotelType::class, $hotel);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($hotel);
        $entityManager->flush();

        return $this->redirectToRoute('app_hotel_index_Front', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Front/hotel/addHotel.html.twig', [
        'hotel' => $hotel,
        'form' => $form,
    ]);
}

#[Route('/{idHotel}', name: 'app_hotel_show_Front', methods: ['GET'])]
public function showFront(Hotel $hotel): Response
{
    return $this->render('Front/hotel/show.html.twig', [
        'hotel' => $hotel,
    ]);
}

#[Route('/{idHotel}/editFront', name: 'app_hotel_edit_Font', methods: ['GET', 'POST'])]
public function editFront(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(HotelType::class, $hotel);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_hotel_index_Front', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Front/hotel/edit.html.twig', [
        'hotel' => $hotel,
        'form' => $form,
    ]);
}
*/


#[Route('Front/reservation/tricroi', name: 'triFrontHotel', methods: ['GET','POST'])]
public function triCroissantFront( \App\Repository\HotelRepository $hotelRepository): Response
{
    $hotel = $hotelRepository->findAllSorted();

    return $this->render('Front/hotel/index.html.twig', [
        'hotels' => $hotel,
    ]);
}

#[Route('Front/reservation/tridesc', name: 'tridFrontHotel', methods: ['GET','POST'])]
public function triDescroissantFront( \App\Repository\HotelRepository $hotelRepository): Response
{
    $hotel = $hotelRepository->findAllSorted1();

    return $this->render('Front/hotel/index.html.twig', [
        'hotels' => $hotel,
    ]);
}




#[Route('Back/hotel/tricroi', name: 'triBackHotel', methods: ['GET','POST'])]
public function triCroissantBack( \App\Repository\HotelRepository $hotelRepository): Response
{
    $hotel = $hotelRepository->findAllSorted();

    return $this->render('Back/hotel/index.html.twig', [
        'hotels' => $hotel,
    ]);
}

#[Route('Back/hotel/tridesc', name: 'tridBackHotel', methods: ['GET','POST'])]
public function triDescroissantBack( \App\Repository\HotelRepository $hotelRepository): Response
{
    $hotel = $hotelRepository->findAllSorted1();

    return $this->render('Back/hotel/index.html.twig', [
        'hotels' => $hotel,
    ]);
}



#[Route('/hotel/search', name: 'search2', methods: ['GET', 'POST'])]
public function advancedSearch(Request $request, HotelRepository $hotelRepository): Response
{
    $query = $request->query->get('query');
    $idHotel = $request->query->get('idHotel');
    $nomHotel = $request->query->get('nomHotel');
    $adressHotel = $request->query->get('adressHotel');

    $hotels = $hotelRepository->advancedSearch($query, $idHotel, $nomHotel, $adressHotel);

    return $this->render('Front/hotel/index.html.twig', [
        'hotels' => $hotels,
    ]);
}



#[Route('Back/hotel/search', name: 'search2Back', methods: ['GET', 'POST'])]
public function advancedSearchBack(Request $request, HotelRepository $hotelRepository): Response
{
    $query = $request->query->get('query');
    $idHotel = $request->query->get('idHotel');
    $nomHotel = $request->query->get('nomHotel');
    $adressHotel = $request->query->get('adressHotel');

    $hotels = $hotelRepository->advancedSearch($query, $idHotel, $nomHotel, $adressHotel);

    return $this->render('Back/hotel/index.html.twig', [
        'hotels' => $hotels,
    ]);
}



#[Route('Front/search', name: 'app_hotel_search_front', methods: ['GET'])]
public function searchFront(Request $request, HotelRepository $HotelRepository): JsonResponse
{
    $query = $request->query->get('q');
    $results = $HotelRepository->findBySearchQuery($query); // Implement findBySearchQuery method in your repository

    $formattedResults = [];
    foreach ($results as $result) {
        // Format results as needed
        $formattedResults[] = [
            'idHotel' => $result->getIdHotel(),
            'nomHotel' => $result->getNomHotel(),
            'adressHotel' => $result->getAdressHotel(),
            'prix1' => $result->getPrix1(),
            'prix2' => $result->getPrix2(),
            'prix3' => $result->getPrix3(),
            'numero1' => $result->getNumero1(),
            'numero2' => $result->getNumero2(),
            'numero3' => $result->getNumero3(),


            // Add other fields as needed
        ];
    }

    return new JsonResponse($formattedResults);
}



#[Route('/hotel/front', name: 'app_hotel_front')]
public function front(HotelRepository $hotelRepository): Response
{
    $hotels = $hotelRepository->findAll();

    return $this->render('Front/hotel/front.html.twig', [
        'hotels' => $hotels, 
    ]); 
    
}



}
