<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\DoctorType;
use App\Repository\MedecinRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;



use Symfony\Component\Routing\Annotation\Route;

class MedecinController extends AbstractController
{
    
    #[Route('/medecin', name: 'app_medecin_add')]
    public function addDoctor(): Response
    {
        return $this->render('Back/medecin/addDoctor.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }

    #[Route('/addDoctor', name: 'app_medecin_add')]
    public function new(Request $request, ManagerRegistry $doctrine) : Response {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        $doctor = new Medecin();
        // $doctor->setNomMedecin('karim');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($doctor);
        $form = $this->createForm(DoctorType::class, $doctor); 

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $doctor = $form->getData();
            // dump($doctor); for debugging
            // TODO ... perform some action, such as saving the task to the database
            $entityManager->flush();
            return $this->redirectToRoute('app_medecin_getAll');
        }
        // rendering the form
        return $this->render('Back/medecin/addDoctor.html.twig', [
            'form' => $form->createView(),
        ]);
             
    }
    #[Route('/medecin/search', name: 'app_medecins_search')]
    public function search(Request $request, MedecinRepository $medecinRepository, PaginatorInterface $paginator): Response
    {
        $query = $request->query->get('query');
        if ($query) {
            $medecins = $medecinRepository->createQueryBuilder('a')
                ->where('a.nomMedecin LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery();


            $doctors = $paginator->paginate(
                $medecins, 
                $request->query->getInt('page', 1), 
                10 
            );
        } else {

            $query = $medecinRepository->findAll(); // Assuming you have a custom query method in your repository
            $doctors = $paginator->paginate(
                $query,
            $request->query->getInt('page', 1), // Current page number
            4 // Items per page
        );
        }

        return $this->render('Back/medecin/showDoctors.html.twig', [
            'doctors' => $doctors,
        ]);
    }
    #[Route('/medecin/tri', name: 'app_medecins_tri')]
    public function tri(Request $request, MedecinRepository $medecinRepository , PaginatorInterface $paginator): Response
    {
        $order = $request->query->get('order', 'asc'); 
        $field = $request->query->get('field', 'nomMedecin'); 

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc'; 
        }

        if (!in_array($field, ['nomMedecin', 'date'])) {
            $field = 'nomMedecin'; 
        }

        $queryBuilder = $medecinRepository->createQueryBuilder('a')
            ->orderBy('a.' . $field, $order);

        $doctors = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10 
        );
        return $this->render('Back/medecin/showDoctors.html.twig', [
            'doctors' => $doctors,

        ]);
    }

    #[Route('/doctorList', name: 'app_medecin_getAll')]
    public function showDoctors(MedecinRepository $medecinRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $query = $medecinRepository->findAll(); // Assuming you have a custom query method in your repository
        $doctors = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Current page number
            4 // Items per page
        );
    
        return $this->render('Back/medecin/showDoctors.html.twig', [
            'doctors' => $doctors,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_medecin_delete')]
    public function deleteDoctor(ManagerRegistry $doctrine, MedecinRepository $medecinRepository, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $doctor = $medecinRepository->find($id);
        $entityManager->remove($doctor);
        $entityManager->flush();
        return $this->redirectToRoute('app_medecin_getAll');
    }

    #[Route('/edit/{id}', name: 'app_medecin_edit')]
    public function editDoctor(ManagerRegistry $doctrine,Request $request, Medecin $doctor , MedecinRepository $medecinRepository, int $id): Response
    {
        $form = $this->createForm(DoctorType::class, $doctor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            // $entityManager->persist($product), but it isn't necessary: 
            // Doctrine is already "watching" your object for changes.
            $entityManager->flush();
            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('app_medecin_getAll');
        }
        
        return $this->render('Back/medecin/editDoctor.html.twig', [
            'doctor' => $doctor,
            'form' => $form->createView(),
        ]);
    }
}
