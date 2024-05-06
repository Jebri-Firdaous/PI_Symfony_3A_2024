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
use Knp\Component\Pager\PaginatorInterface;

use function PHPSTORM_META\type;

class ParkingController extends AbstractController
{
    #[Route('home/parking/', name: 'app_parkingF', methods: ['GET'])]
    public function indexFront(ParkingRepository $parkingRepository): Response
    {
        // session_start();
        // var_dump($_SESSION['user']);
        return $this->render('Front/parking/index.html.twig', [
            'parkings' => $parkingRepository->findAll(),
            'repo' => $parkingRepository,
            'controller_name' => 'ParkingController',
        ]);
    }

    #[Route('back/parking/', name: 'app_parkingB', methods: ['GET'])]
    public function indexBack(ParkingRepository $parkingRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $query = $parkingRepository->findAll();

    // Paginate the results
    $parkings = $paginator->paginate(
        $query, // Query
        $request->query->getInt('page', 1), // Page number
        3 // Items per page
    );
        return $this->render('Back/parking/index.html.twig', [
            // 'parkings' => $parkingRepository->findAll(),
            'pag' => $parkings,
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

            // $filename = 'parking/recycle.txt';
            // $lines = file($filename);
            // $new = $parking->getNomParking().','.$parking->getAddressParking().','
            // .$parking->getLatitude().','.$parking->getLongitude().','.$parking->getNombrePlaceMax().','.$parking->getNombrePlaceOcc()
            // .','.$parking->getEtatParking(). PHP_EOL;
            // $lines[] = $new;
            // file_put_contents($filename, implode('', $lines));
            $filename = 'parking/recycle.txt';
            $lines = file($filename);

            $new = PHP_EOL . $parking->getNomParking() . ',' . $parking->getAddressParking() . ','
                . $parking->getLatitude() . ',' . $parking->getLongitude() . ',' . $parking->getNombrePlaceMax() . ',' . $parking->getNombrePlaceOcc()
                . ',' . $parking->getEtatParking() ;

            // Append the new content to the end of the file
            file_put_contents($filename, $new, FILE_APPEND);


            $entityManager->remove($parking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parkingB', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('back/stat', name: 'app_parking_stat', methods: ['GET', 'POST'])]
    public function stat(ParkingRepository $parkingRepository): Response
    {
        $parkings=$parkingRepository->findAll();

        $filename = 'parking/datachart.txt';
        $lines = file($filename);

        foreach ($parkings as $parking) {
            $test=false;
            foreach($lines as $lineNumber => $line){
                $parts = explode(',', $line, 2);
                if (trim($parts[0]) === $parking->getNomParking()) {
                    $test=true;
                }
            }
            if(!$test){
                $lines[count($lines)]=$parking->getNomParking().",0". PHP_EOL;
            }
            file_put_contents($filename, implode('', $lines));
        }
        $lines = file($filename);
        $val = [];
        foreach($lines as $lineNumber => $line){
            $parts = explode(',', $line, 2);
            $val[] = trim($parts[1]);
        }

        return $this->render('back/parking/chart.html.twig', [
            'parkings' => $parkings,
            'repo' => $parkingRepository,
            'values' => $val,
            'controller_name' => 'ParkingController',
        ]);
        // return $this->redirectToRoute('app_parkingB', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('back/recycle', name: 'app_parking_recy', methods: ['GET', 'POST'])]
    public function recycle(ParkingRepository $parkingRepository, EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $filename = 'parking/recycle.txt';
        $lines = file($filename);
        $parkings = [];

        foreach ($lines as $lineNumber => $line) {
            $parts = explode(',', $line, 7);
            $parking = new Parking(); // Create a new Parking object for each iteration
            $parking->setNomParking($parts[0]);
            $parking->setAddressParking($parts[1]);
            $parking->setLatitude($parts[2]);
            $parking->setLongitude($parts[3]);
            $parking->setNombrePlaceMax($parts[4]);
            $parking->setNombrePlaceOcc($parts[5]);
            $parking->setEtatParking($parts[6]);

            array_push($parkings, $parking);
        }


    // Paginate the results
    $pag = $paginator->paginate(
        $parkings, // Query
        $request->query->getInt('page', 1), // Page number
        3 // Items per page
    );

        return $this->render('back/parking/recycle.html.twig', [
            'parkings' => $pag,
            'repo' => $parkingRepository,
            'controller_name' => 'ParkingController',
        ]);
        // return $this->redirectToRoute('app_parkingB', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('back/recycle/{id}', name: 'app_parking_recyBtn', methods: ['GET', 'POST'])]
    public function recycleBtn(ParkingRepository $parkingRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $filename = 'parking/recycle.txt';
        $lines = file($filename);
        $parkings = [];
        $i = 0;

            foreach($lines as $lineNumber => $line){
                $parts = explode(',', $line, 7);
                $parking = new Parking();
                $parking->setNomParking($parts[0]);
                $parking->setAddressParking($parts[1]);
                $parking->setLatitude($parts[2]);
                $parking->setLongitude($parts[3]);
                $parking->setNombrePlaceMax($parts[4]);
                $parking->setNombrePlaceOcc($parts[5]);
                $parking->setEtatParking($parts[6]);
                $new = $parking->getNomParking().','.$parking->getAddressParking().','
            .$parking->getLatitude().','.$parking->getLongitude().','.$parking->getNombrePlaceMax().','.$parking->getNombrePlaceOcc()
            .','.$parking->getEtatParking(). PHP_EOL;
                if($i == $id){
                //     $lines[$i] = $new;
                //     array_push($parkings, $parking);
                // }else{
                    $entityManager->persist($parking);
                    $entityManager->flush();
                    $i--;
                }
                $i++;
        }
        // unset($parkings[$id]);
        unset($lines[$id - 1]);

        // file_put_contents($filename, '');
        file_put_contents($filename, implode('', $lines));

        return $this->redirectToRoute('app_parking_recy', [], Response::HTTP_SEE_OTHER);
        // return $this->redirectToRoute('app_parkingB', [], Response::HTTP_SEE_OTHER);
    }
}
