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

#[Route('/hotel')]
class HotelController extends AbstractController
{
    #[Route('/listHotel', name: 'app_hotel_index', methods: ['GET'])]
    public function index(HotelRepository $hotelRepository): Response
    {
        return $this->render('Back/hotel/index.html.twig', [
            'hotels' => $hotelRepository->findAll(),
        ]);
    }

   #[Route('/listHotelFront', name: 'app_hotel_index_Front', methods: ['GET'])]
public function indexFront(HotelRepository $hotelRepository): Response
{
    return $this->render('Front/hotel/index.html.twig', [
        'hotels' => $hotelRepository->findAll(),
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


}
