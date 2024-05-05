<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\RendezVousType;
use App\Form\RendezVousBackType;
use App\Repository\ClientRepository as ClientRepository;
use App\Repository\MedecinRepository;
use App\Repository\RendezVousRepository;
use App\Repository\UserRepository;

class RendezVousController extends AbstractController
{
    #[Route('/rendez/vous', name: 'app_rendez_vous')]
    public function index(): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }

   

    #[Route('/addRendezVousFront', name: 'front_rendezVous_add')]
    public function addRendezVous(Request $request, ManagerRegistry $doctrine, MedecinRepository $medecinRepository): Response
    {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        $rendezVous = new RendezVous();
        $client = $doctrine->getRepository(User::class)->find(55);
        // $personne = $doctrine->getRepository(Personne::class)->find(55);
        // dump($personne);
        // $client = $clientRepository->find($personne);
        dump($client);
        $rendezVous->setUser($client);

        
        // $rendezVous->setIdPersonne($client);
        $entityManager->persist($rendezVous);
        $form = $this->createForm(RendezVousType::class, $rendezVous, ['medecinRepository' => $medecinRepository]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->get('id')->setData(34); // Set id to 34
            // holds the submitted values
            // but, the original `$task` variable has also been updated
            $rendezVous = $form->getData();
            // TODO ... perform some action, such as saving the task to the database
            $entityManager->flush();
            // return $this->redirectToRoute('app_medecin_getAll');
            return $this->redirectToRoute('front_rendezVous_getAll');
        }

        return $this->render('Front/rendez_vous/addRendezVous.html.twig', [
            'controller_name' => 'RendezVousController',
            'form' => $form->createView(),
            // 'data' => $data,

        ]);
    }

    #[Route('/Rvbyclient', name: 'front_rendezVous_getAll')]
    public function showAllRendezVousBySession(RendezVousRepository $rendezVousRepository,
    MedecinRepository $medecinRepository , UserRepository $userRepository): Response
    {
        $client = $userRepository->find(55);
        dump($client);
        $lesRendezVousByClient =  $client->getLesRendezVous();
        dump($lesRendezVousByClient);

        return $this->render('Front/rendez_vous/showRV.html.twig', [
            'controller_name' => 'RendezVousController',
            'lesRVdeClient' => $lesRendezVousByClient,
        ]);
    }

    #[Route('/deleteRVFront/{id}', name: 'front_rendezVous_delete')]
    public function deleteRendezVous(Request $request, ManagerRegistry $doctrine, RendezVousRepository $rendezVousRepository, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        dump($id);

        $rendezVous = $rendezVousRepository->find($id);
        dump($rendezVous);

        
        // $rendezVous->setIdPersonne($client);
        $entityManager->remove($rendezVous);
        $entityManager->flush();

        return $this->redirectToRoute('front_rendezVous_getAll');
    }


    #[Route('/editRVFront/{id}', name: 'front_rendezVous_edit')]
    public function editRendezVousbyclient(Request $request, ManagerRegistry $doctrine, RendezVous $rendezVous ,RendezVousRepository $rendezVousRepository, int $id): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            // $entityManager->persist($product), but it isn't necessary: 
            // Doctrine is already "watching" your object for changes.
            $entityManager->flush();
            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('front_rendezVous_getAll');
        }
        
        return $this->render('Front/rendez_vous/editRendezVous.html.twig', [
            'rendezvous' => $rendezVous,
            'form' => $form->createView(),
        ]);

      
    }



    
    #[Route('/allRVExist', name: 'back_rendezVous_getAll')]
    public function showAllRendezVousForAdmin(RendezVousRepository $rendezVousRepository,MedecinRepository $medecinRepository ,ClientRepository $clientRepository): Response
    {
        $allRVInDB = $rendezVousRepository->findAll();
        dump($allRVInDB);

        return $this->render('Back/rendezVous/showAllRvInDB.html.twig', [
            'controller_name' => 'RendezVousController',
            'lesRVdeClient' => $allRVInDB,
        ]);
    }
    #[Route('/addRendezVousBack', name: 'back_rendezVous_add')]
    public function addRendezVousBack(Request $request, ManagerRegistry $doctrine, UserRepository $userRepository, MedecinRepository $medecinRepository): Response
    {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        $rendezVous = new RendezVous();

        // $personne = $doctrine->getRepository(Personne::class)->find(55);
        // dump($personne);

        // $client = $clientRepository->find($personne);
        // dump($client);
        // $rendezVous->setIdPersonne($client);

        
        // $rendezVous->setIdPersonne($client);
        $entityManager->persist($rendezVous);
        $form = $this->createForm(RendezVousBackType::class, $rendezVous, ['medecinRepository' => $medecinRepository], ['userRepository' => $userRepository],['entityManager' => $entityManager]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->get('id')->setData(34); // Set id to 34
            // holds the submitted values
            // but, the original `$task` variable has also been updated
            $rendezVous = $form->getData();
            // TODO ... perform some action, such as saving the task to the database
            $entityManager->flush();
            // return $this->redirectToRoute('app_medecin_getAll');
            return $this->redirectToRoute('back_rendezVous_getAll');
        }
        // if ($form->isSubmitted() && !$form->isValid()) {
        //     // Dump all form errors
        //     dump($form->getErrors(true));
        // }

        return $this->render('Back/rendezVous/addRendezVousBack.html.twig', [
            'controller_name' => 'RendezVousController',
            'form' => $form->createView(),

        ]);
    }
    
    #[Route('/editRVBack/{id}', name: 'back_rendezVous_edit')]
    public function editRendezVousBack(Request $request, ManagerRegistry $doctrine, RendezVous $rendezVous ,RendezVousRepository $rendezVousRepository, int $id): Response
    {
        $form = $this->createForm(RendezVousBackType::class, $rendezVous);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            // $entityManager->persist($product), but it isn't necessary: 
            // Doctrine is already "watching" your object for changes.
            $entityManager->flush();
            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('back_rendezVous_getAll');
        }
        
        return $this->render('Back/rendezVous/editRendezVousBack.html.twig', [
            'rendezvous' => $rendezVous,
            'form' => $form->createView(),
        ]);

      
    }
    #[Route('/rendezvous/searchFront', name: 'front_app_rv_search')]
    public function searchFront(Request $request,ClientRepository $clientRepository ,RendezVousRepository $rendezVousRepository, PaginatorInterface $paginator): Response
    {
        $query = $request->query->get('query');
        $client = $clientRepository->find(55);
        if ($query) {
            $qb = $rendezVousRepository->createQueryBuilder('r');
            $qb->leftJoin('r.id_medecin', 'm')
                ->where($qb->expr()->like("DATE_FORMAT(r.dateRendezVous, '%d/%m/%Y')", ':date'))
                ->orWhere($qb->expr()->like('m.nomMedecin', ':nomMedecin'))
                ->andWhere($qb->expr()->eq('r.id_personne', ':idPersonne'))
                ->setParameter('date', '%' . $query . '%') 
                ->setParameter('nomMedecin', $query . '%') 
                ->setParameter('idPersonne', $client ) 
                ->getQuery()
                ->getResult();


            // $listrendezVous = $rendezVousRepository->createQueryBuilder('r')
            //     ->join('r.id_medecin', 'm')
            //     ->where('m.nomMedecin LIKE :query')
            //     ->setParameter('query', $query . '%')
            //     ->getQuery()
            //     ->getResult();



            $lesRVdeClient = $paginator->paginate(
                // $listrendezVous, 
                $qb,
                $request->query->getInt('page', 1), 
                10 
            );

        } else {
            return $this->redirectToRoute('front_rendezVous_getAll');

            // $query = $rendezVousRepository->findAll(); // Assuming you have a custom query method in your repository
            // $lesRVdeClient = $paginator->paginate(
            //     $query,
            // $request->query->getInt('page', 1), // Current page number
            // 4 // Items per page
            //  );
        }
        return $this->render('Front/rendez_vous/showRV.html.twig', [
            'lesRVdeClient' => $lesRVdeClient,
        ]);
    }

    #[Route('/rendezvous/search', name: 'app_rv_search')]
    public function search(Request $request, RendezVousRepository $rendezVousRepository, PaginatorInterface $paginator): Response
    {
        $query = $request->query->get('query');
        if ($query) {
            $qb = $rendezVousRepository->createQueryBuilder('r');
            $qb->leftJoin('r.id_medecin', 'm')
                ->where($qb->expr()->like("DATE_FORMAT(r.dateRendezVous, '%d/%m/%Y')", ':date'))
                ->orWhere($qb->expr()->like('m.nomMedecin', ':nomMedecin'))
                ->setParameter('date', '%' . $query . '%') 
                ->setParameter('nomMedecin', $query . '%') 
                ->getQuery()
                ->getResult();


            // $listrendezVous = $rendezVousRepository->createQueryBuilder('r')
            //     ->join('r.id_medecin', 'm')
            //     ->where('m.nomMedecin LIKE :query')
            //     ->setParameter('query', $query . '%')
            //     ->getQuery()
            //     ->getResult();



            $lesRVdeClient = $paginator->paginate(
                // $listrendezVous, 
                $qb,
                $request->query->getInt('page', 1), 
                10 
            );
        } else {
            return $this->redirectToRoute('back_rendezVous_getAll');

            // $query = $rendezVousRepository->findAll(); // Assuming you have a custom query method in your repository
            // $lesRVdeClient = $paginator->paginate(
            //     $query,
            // $request->query->getInt('page', 1), // Current page number
            // 4 // Items per page
            //  );
        }

        return $this->render('Back/rendezVous/showAllRvInOtherForm.html.twig', [
            'lesRVdeClient' => $lesRVdeClient,
        ]);
    }

    
    #[Route('/rv/tri', name: 'app_rv_tri')]
public function tri(Request $request, RendezVousRepository $rendezVousRepository, PaginatorInterface $paginator): Response
{
    $order = $request->query->get('order', 'asc');
    $field = $request->query->get('field', 'date');

    if (!in_array(strtolower($order), ['asc', 'desc'])) {
        $order = 'asc';
    }

    if (!in_array($field, ['date', 'nomMedecin'])) {
        $field = 'date';
    }

    $queryBuilder = $rendezVousRepository->createQueryBuilder('r');
    $queryBuilder->leftJoin('r.id_medecin', 'm');

    if ($field === 'date') {
        $queryBuilder->orderBy('r.dateRendezVous', $order);
    } else {
        $queryBuilder->orderBy('m.nomMedecin', $order);
    }

    $rendezvous = $queryBuilder->getQuery()->getResult();

    return $this->render('Back/rendezVous/showAllRvInOtherForm.html.twig', [
        'lesRVdeClient' => $rendezvous,
    ]);
}

#[Route('/rv/triclient', name: 'front_app_rv_tri')]
public function triforClient(Request $request, RendezVousRepository $rendezVousRepository, 
 ClientRepository $clientRepository ,PaginatorInterface $paginator): Response
{
    $order = $request->query->get('order', 'asc');
    $field = $request->query->get('field', 'date');
    $client = $clientRepository->find(55);
    // $idPersonne = $request->query->get('idPersonne'); // Récupération de l'ID de la personne

    if (!in_array(strtolower($order), ['asc', 'desc'])) {
        $order = 'asc';
    }

    if (!in_array($field, ['date', 'nomMedecin'])) {
        $field = 'date';
    }

    $queryBuilder = $rendezVousRepository->createQueryBuilder('r');
    $queryBuilder->leftJoin('r.id_medecin', 'm')
                 ->where($queryBuilder->expr()->eq('r.id_personne', ':idPersonne')) // Ajout de la condition sur l'ID de la personne
                 ->setParameter('idPersonne', $client); // Passage de la valeur du paramètre

    if ($field === 'date') {
        $queryBuilder->orderBy('r.dateRendezVous', $order);
    } else {
        $queryBuilder->orderBy('m.nomMedecin', $order);
    }

    $rendezvous = $queryBuilder->getQuery()->getResult();
    $lesRVdeClient = $paginator->paginate(
        // $listrendezVous, 
        $rendezvous,
        $request->query->getInt('page', 1), 
        6
    );

    return $this->render('Front/rendez_vous/showRV.html.twig', [
        'lesRVdeClient' => $lesRVdeClient,
    ]);
}



    


    #[Route('/deleteRVBack/{id}', name: 'back_rendezVous_delete')]
    public function deleteRendezVousfromAdmin(Request $request, ManagerRegistry $doctrine, RendezVousRepository $rendezVousRepository, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        dump($id);

        $rendezVous = $rendezVousRepository->find($id);
        dump($rendezVous);

        
        // $rendezVous->setIdPersonne($client);
        $entityManager->remove($rendezVous);
        $entityManager->flush();

        return $this->redirectToRoute('back_rendezVous_getAll');
    }
}
