<?php

namespace App\Controller;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use App\Repository\ParkingRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlaceController extends AbstractController
{
    #[Route('front/place/{idP}', name: 'app_place_indexF', methods: ['GET'])]
    public function indexF(PlaceRepository $placeRepository, $idP): Response
    {
        session_start();

        // echo $_SESSION['user_id'];
        $result = $placeRepository->findByIdClient($_SESSION['user_id']);
        
        if($result == null){
            return $this->render('Front/place/index.html.twig', [
            'places' => $placeRepository->findByIdPark($idP),
            'idP' => $idP,
            ]);
        }else{
            return $this->render('Front/place/reserved.html.twig', [
                'places' => $placeRepository->findByIdPark($idP),
                'place' => $result,
                'idP' => $idP,
            ]);
        }
        
    }

    #[Route('back/place/{idP}', name: 'app_place_indexB', methods: ['GET'])]
    public function indexB(PlaceRepository $placeRepository, $idP, Request $request): Response
    {
        return $this->render('Back/place/index.html.twig', [
            'places' => $placeRepository->findByIdPark($idP),
            'idP' => $idP,
        ]);
    }

    #[Route('back/place/{idP}/{refP}', name: 'app_place_reserve', methods: ['GET'])]
    public function reserve(PlaceRepository $placeRepository, ParkingRepository $parkingRepository, $idP, $refP, EntityManagerInterface $entityManager): Response
    {
        $place = $placeRepository->find($refP);
        $parking = $parkingRepository->find($idP);
        $tmp = $parking->getNombrePlaceOcc();
        if($place->getEtat() == 'Libre'){
            $place->setEtat('Reservée');
            $parking->setNombrePlaceOcc($tmp+1);
            if($parking->getNombrePlaceOcc() == $parking->getNombrePlaceMax())
                $parking->setEtatParking('Plein');

            $entityManager->persist($place, $parking);
            $entityManager->flush();

            return $this->redirectToRoute('app_place_indexB', ['idP' => $idP], Response::HTTP_SEE_OTHER);
        }else{
            $place->setEtat('Libre');
            $parking->setNombrePlaceOcc($tmp-1);
            if($parking->getNombrePlaceOcc() < $parking->getNombrePlaceMax())
                $parking->setEtatParking('Disponible');

            $entityManager->persist($place, $parking);
            $entityManager->flush();

            return $this->redirectToRoute('app_place_indexB', ['idP' => $idP], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('back/place1/{idP}/{refP}', name: 'app_place_reserveF', methods: ['GET'])]
    public function reserveFront(PlaceRepository $placeRepository, ParkingRepository $parkingRepository, ClientRepository $clientRepository, $idP, $refP, EntityManagerInterface $entityManager): Response
    {
        session_start();

        $client = $clientRepository->find($_SESSION['user_id']);
        $place = $placeRepository->find($refP);
        $parking = $parkingRepository->find($idP);
        $tmp = $parking->getNombrePlaceOcc();

        $place->setEtat('Reservee');
        $parking->setNombrePlaceOcc($tmp+1);
        if($parking->getNombrePlaceOcc() == $parking->getNombrePlaceMax())
            $parking->setEtatParking('Plein');
        $place->setIdPersonne($client);

        $entityManager->persist($place, $parking);
        $entityManager->flush();

        return $this->redirectToRoute('app_place_indexF', ['idP' => $idP], Response::HTTP_SEE_OTHER);
    }

    #[Route('back/place2/{idP}/{refP}', name: 'app_place_annulerRes', methods: ['GET'])]
    public function AnnulerRes(PlaceRepository $placeRepository, ParkingRepository $parkingRepository, $idP, $refP, EntityManagerInterface $entityManager): Response
    {
        $place = $placeRepository->find($refP);
        $parking = $parkingRepository->find($idP);
        $tmp = $parking->getNombrePlaceOcc();

        $place->setEtat('Libre');
        $parking->setNombrePlaceOcc($tmp-1);
        if($parking->getNombrePlaceOcc() < $parking->getNombrePlaceMax())
            $parking->setEtatParking('Disponible');
        $place->setIdPersonne(null);

        $entityManager->persist($place, $parking);
        $entityManager->flush();

        return $this->redirectToRoute('app_parkingF');
    }

    #[Route('back/place/{idP}/0/new', name: 'app_place_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, $idP, ParkingRepository $parkingRepository, PlaceRepository $placeRepository): Response
    {
        $place = new Place();
        $parking = $parkingRepository->find($idP);
        $numberList = [];
        $usedNumbers = [];
        $list=$placeRepository->findByIdPark($idP);
        foreach ($list as $p) {
            $usedNumbers[] = $p->getNumPlace();
        }
        
        // Generate a list of available numbers
        $parkingMax = $parking->getNombrePlaceMax();
        for ($i = 1; $i <= $parkingMax; $i++) {
            if (!in_array($i, $usedNumbers) && $parkingRepository->nbPlaces($idP)!=0) {
                var_dump($i);
                $numberList[] = $i;
            }elseif($parkingRepository->nbPlaces($idP)==0)
                $numberList[] = $i;
        }
        var_dump($numberList);
        var_dump($usedNumbers);
        $form = $this->createForm(PlaceType::class, $place, ['parking' => $parking, 'list' => $numberList]);
        $form->handleRequest($request);
        if($parking->getNombrePlaceMax() > $parkingRepository->nbPlaces($idP))
        {
            if ($form->isSubmitted() && $form->isValid()) {
                // $park=$parkingRepository->find($idP);
                // $park->setNombrePlaceOcc($park->getNombrePlaceOcc()+1);
                $place->setIdParking($parkingRepository->find($idP));
                $place->setEtat('Libre');
                
                $entityManager->persist($place);
                $entityManager->flush();

                return $this->redirectToRoute('app_place_indexB', ['idP' => $idP], Response::HTTP_SEE_OTHER);
            }
        }else{
            return $this->redirectToRoute('app_place_indexB', ['idP' => $idP], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('Back/place/new.html.twig', [
            'place' => $place,
            'form' => $form,
            'idP' => $idP,
        ]);
    }

    #[Route('back/place/{idP}/{refPlace}/show', name: 'app_place_show', methods: ['GET'])]
    public function show(Place $place, $idP): Response
    {
        return $this->render('Back/place/show.html.twig', [
            'place' => $place,
            'idP' => $idP,
        ]);
    }

    #[Route('back/place/{idP}/{refPlace}/edit', name: 'app_place_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Place $place, $idP, EntityManagerInterface $entityManager, ParkingRepository $parkingRepository, PlaceRepository $placeRepository): Response
    {
        $parking = $parkingRepository->find($idP);
        $numberList = [];
        $usedNumbers = [];
        $list=$placeRepository->findByIdPark($idP);
        foreach ($list as $p) {
            $usedNumbers[] = $p->getNumPlace();
        }
        
        // Generate a list of available numbers
        $parkingMax = $parking->getNombrePlaceMax();
        for ($i = 1; $i <= $parkingMax; $i++) {
            if (!in_array($i, $usedNumbers)) {
                $numberList[] = $i;
            }
        }
        $numberList[] = $place->getNumPlace();
        var_dump($numberList);
        var_dump($parkingMax);
        $form = $this->createForm(PlaceType::class, $place, ['parking' => $parking, 'list' => $numberList]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_place_indexB', ['idP' => $idP], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/place/edit.html.twig', [
            'place' => $place,
            'form' => $form,
            'idP' => $idP,
        ]);
    }

    #[Route('back/place/{idP}/{refPlace}/show', name: 'app_place_delete', methods: ['POST'])]
    public function delete(Request $request, Place $place, $idP, EntityManagerInterface $entityManager, ParkingRepository $parkingRepository): Response
    {
        $parking = $parkingRepository->find($idP);
        $tmp = $parking->getNombrePlaceOcc();

        if ($this->isCsrfTokenValid('delete'.$place->getRefPlace(), $request->request->get('_token'))) {
            if($place->getEtat() == 'Reservée'){
                $parking->setNombrePlaceOcc($tmp-1);
                if($parking->getNombrePlaceOcc() < $parking->getNombrePlaceMax())
                    $parking->setEtatParking('Disponible');
            }
            
            $entityManager->remove($place);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_place_indexB', ['idP' => $idP], Response::HTTP_SEE_OTHER);
    }
}
