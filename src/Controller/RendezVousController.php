<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Client;
use App\Entity\Personne;
use App\Entity\RendezVous;
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
use App\Service\SmsGenerator;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;


class RendezVousController extends AbstractController
{
    #[Route('/rendez/vous', name: 'app_rendez_vous')]
    public function index(): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }

    #[Route('/testsaving', name: 'rv')]
    public function test(ManagerRegistry $doctrine): Response
    {
        $personne = new Personne();
        $personne->setNomPersonne('df');
        $personne->setPrenomPersonne('badfhira');
        $personne->setMailPersonne('kajofm');
        $personne->setMdpPersonne('kafdrfim');
        $personne->setImagePersonne('kardfim');
        $personne->setNumeroTelephone(4576);

        $administrateur = new Administrateur();
        $administrateur->setRole("gestion Medecin");
        $administrateur->setPersonne($personne);
        dump($personne);

        // relates this product to the category
        // $client->setIdPersonne($personne);

        $entityManager = $doctrine->getManager();

        $entityManager->persist($personne);
        // $entityManager->flush();
        $entityManager->persist($administrateur);
        $entityManager->flush();

        return new Response(
            'Saved new admin with id: ' . $administrateur->getPersonne()->getNomPersonne() . $administrateur->getPersonne()->getId() 
            .' and new personne with id: '.$personne->getId()
        );
    }

    #[Route('/testFetchClient', name: 'fetclmhtest')]
    public function testFetchClient(ManagerRegistry $doctrine): Response
    {
        $client = $doctrine->getRepository(Client::class)->find(56);
    

        return new Response(
            'fetch old client ' . $client->getPersonne()->getNomPersonne() . $client->getPersonne()->getId() . "genre" . $client->getGenre()
            // .' and new personne with id: '.$personne->getId()
        );

    }
    #[Route('/testFetchAdmin', name: 'fetchtest')]
    public function testFetch(ManagerRegistry $doctrine): Response
    {
        $administrateur = $doctrine->getRepository(Administrateur::class)->find(55);
    

        return new Response(
            'fetch old admin ' . $administrateur->getPersonne()->getNomPersonne() . $administrateur->getPersonne()->getId() 
            . $administrateur->getRole()
            // .' and new personne with id: '.$personne->getId()
        );
    }
    #[Route('/addRendezVousFront', name: 'front_rendezVous_add')]
    public function addRendezVous(Request $request, ManagerRegistry $doctrine, 
    ClientRepository $clientRepository, MedecinRepository $medecinRepository, SmsGenerator $smsGenerator,
    MailerInterface $mailer): Response
    {
        $entityManager = $doctrine->getManager();
        // creates a doctor object and initializes some data for this example
        $rendezVous = new RendezVous();
        $personne = $doctrine->getRepository(Personne::class)->find(55);
        dump($personne);
        $client = $clientRepository->find($personne);
        dump($client);
        $rendezVous->setIdPersonne($client);

        
        // $rendezVous->setIdPersonne($client);
        $entityManager->persist($rendezVous);
        $form = $this->createForm(RendezVousType::class, $rendezVous, ['medecinRepository' => $medecinRepository]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->get('id_personne')->setData(34); // Set id_personne to 34
            // holds the submitted values
            // but, the original `$task` variable has also been updated
            $rendezVous = $form->getData();
            // TODO ... perform some action, such as saving the task to the database
            $entityManager->flush();
            // return $this->redirectToRoute('app_medecin_getAll');
            $medecinNumber = $rendezVous->getIdMedecin()->getNumeroTelephoneMedecin();
            dump($medecinNumber);
            $medecinNom = $rendezVous->getIdMedecin()->getNomMedecin();
            dump($medecinNom);
            $dateRendezVous = $rendezVous->getDateRendezVous();
            dump($dateRendezVous);
            $stringDate = $dateRendezVous->format('d/m/Y'); // for example
            $body = "tu auras un rendez-vous le  ". $stringDate;
            $smsGenerator->SendSms("+4915510686794",$medecinNom, $body);
            // Mailing -------------------
            


            return $this->redirectToRoute('front_rendezVous_getAll');
        }

        // Send email
        $email = (new Email())
        ->from('testpi3a8@outlook.com') // Replace with your email
        ->to('benzbibaezzdine@gmail.com') // Assuming getClient() returns the email
        ->subject('Reservation Confirmation')
        ->text('Your reservation has been confirmed.');

        $mailer->send($email);

        return $this->render('Front/rendez_vous/addRendezVous.html.twig', [
            'controller_name' => 'RendezVousController',
            'form' => $form->createView(),

        ]);
    }
    #[Route('/Rvbyclient', name: 'front_rendezVous_getAll')]
    public function showAllRendezVousBySession(RendezVousRepository $rendezVousRepository,
    MedecinRepository $medecinRepository ,ClientRepository $clientRepository,
    Request $request, PaginatorInterface $paginator): Response
    {
        $client = $clientRepository->find(55);
        $query =  $client->getLesRendezVous();
        $lesRendezVousByClient = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Current page number
            4 // Items per page
        );
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
    public function showAllRendezVousForAdmin(RendezVousRepository $rendezVousRepository,
    MedecinRepository $medecinRepository ,ClientRepository $clientRepository,
    Request $request, PaginatorInterface $paginator): Response
    {
        $allRVInDB = $rendezVousRepository->findAll();
        return $this->render('Back/rendezVous/showAllRvInOtherForm.html.twig', [
            'controller_name' => 'RendezVousController',
            'lesRVdeClient' => $allRVInDB,
        ]);
    }
    #[Route('/addRendezVousBack', name: 'back_rendezVous_add')]
    public function addRendezVousBack(Request $request, ManagerRegistry $doctrine, ClientRepository $clientRepository, 
                                        MedecinRepository $medecinRepository, SmsGenerator $smsGenerator): Response
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
        $form = $this->createForm(RendezVousBackType::class, $rendezVous, ['medecinRepository' => $medecinRepository], ['clientRepository' => $clientRepository],['entityManager' => $entityManager]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->get('id_personne')->setData(34); // Set id_personne to 34
            // holds the submitted values
            // but, the original `$task` variable has also been updated
            $rendezVous = $form->getData();
            // TODO ... perform some action, such as saving the task to the database
            $entityManager->flush();
            // return $this->redirectToRoute('app_medecin_getAll');
            $medecinNumber = $rendezVous->getIdMedecin()->getNumeroTelephoneMedecin();
            dump($medecinNumber);
            $medecinNom = $rendezVous->getIdMedecin()->getNomMedecin();
            dump($medecinNom);
            $dateRendezVous = $rendezVous->getDateRendezVous();
            dump($dateRendezVous);
            $stringDate = $dateRendezVous->format('d/m/Y'); // for example
            $body = "tu auras un rendez-vous le  ". $stringDate;
            $smsGenerator->SendSms("+4915510686794",$medecinNom, $body);
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
