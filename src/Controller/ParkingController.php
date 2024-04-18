<?php

namespace App\Controller;

use App\Entity\Parking;
use App\Entity\Client;
use App\Entity\Personne;
use App\Form\ParkingType;
use App\Repository\ParkingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPSTORM_META\type;

class ParkingController extends AbstractController
{
    #[Route('home/parking/', name: 'app_parkingF', methods: ['GET'])]
    public function indexFront(ParkingRepository $parkingRepository): Response
    {
        return $this->render('Front/parking/index.html.twig', [
            'parkings' => $parkingRepository->findAll(),
            'repo' => $parkingRepository,
            'controller_name' => 'ParkingController',
        ]);
    }

    #[Route('back/parking/', name: 'app_parkingB', methods: ['GET'])]
    public function indexBack(ParkingRepository $parkingRepository): Response
    {
        return $this->render('Back/parking/index.html.twig', [
            'parkings' => $parkingRepository->findAll(),
            'repo' => $parkingRepository,
            'controller_name' => 'ParkingController',
        ]);
    }

    #[Route('back/parking/new', name: 'app_parking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parking = new Parking();
        $form = $this->createForm(ParkingType::class, $parking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parking->setNombrePlaceOcc(0);
            $parking->setEtatParking('Disponible');
            $entityManager->persist($parking);
            $entityManager->flush();

            return $this->redirectToRoute('app_parkingB', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/parking/new.html.twig', [
            'parking' => $parking,
            'form' => $form,
        ]);
    }

    #[Route('back/parking/{idParking}', name: 'app_parking_show', methods: ['GET'])]
    public function show(Parking $parking): Response
    {
        // var_dump($parking->getIdParking());
        return $this->render('Back/parking/show.html.twig', [
            'parking' => $parking,
        ]);
    }

    #[Route('back/parking/{idParking}/edit', name: 'app_parking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parking $parking, EntityManagerInterface $entityManager, ParkingRepository $parkingRepository): Response
    {
        $form = $this->createForm(ParkingType::class, $parking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($parking->getNombrePlaceOcc() < $parkingRepository->nbPlaces($parking->getIdParking()))
                $parking->setEtatParking('Disponible');
            elseif($parking->getNombrePlaceOcc() == $parkingRepository->nbPlaces($parking->getIdParking()))
                $parking->setEtatParking('Plein');
            if($parking->getNombrePlaceMax() < $parkingRepository->nbPlaces($parking->getIdParking()))
                $parking->setNombrePlaceMax($parkingRepository->nbPlaces($parking->getIdParking()));

            $entityManager->flush();

            return $this->redirectToRoute('app_parkingB', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/parking/edit.html.twig', [
            'parking' => $parking,
            'form' => $form,
        ]);
    }

    #[Route('back/parking/{idParking}', name: 'app_parking_delete', methods: ['POST'])]
    public function delete(Request $request, Parking $parking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parking->getIdParking(), $request->request->get('_token'))) {
            $entityManager->remove($parking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parkingB', [], Response::HTTP_SEE_OTHER);
    }
}
