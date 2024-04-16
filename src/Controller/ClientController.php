<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Form\RegistrationClientType;

use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ClientController extends AbstractController
{
    #[Route('/clientGetAll', name: 'client_list')]
    public function listClient(ClientRepository $repo): Response
    {
        $list=$repo->findAll();
        return $this->render('Front/client/index.html.twig', [
            'list' => $list,
        ]);
    }
    #[Route('/clientSignIn', name: 'app_client_signIn')]
    public function signIn(ClientRepository $repo): Response
    {
        
        return $this->render('Front/client/signIn.html.twig', [
           
        ]);
    }
    #[Route('/clientCodeTele', name: 'app_client_code_tele')]
    public function codeTele(ClientRepository $repo): Response
    {
        
        return $this->render('Front/client/codeTele.html.twig', [
           
        ]);
    }
    #[Route('/clientValidate', name: 'app_client_validate')]
    public function Validate(ClientRepository $repo): Response
    {
        
        return $this->render('Front/client/Validate.html.twig', [
           
        ]);
    }

    #[Route('/addClient', name: 'app_client_add')]
    
    public function addClient(Request $request, ManagerRegistry $manager): Response {
        $client = new Client();
    
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the uploaded file
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form['personne']['image_personne']->getData();

        // Check if a file was uploaded
        if ($uploadedFile) {
            // Generate a unique filename for the file
            $newFilename = uniqid().'.'.$uploadedFile->guessExtension();

            // Move the file to the desired directory
            try {
                $uploadedFile->move(
                    $this->getParameter('image_directory'), // Path to the directory where you want to save the file
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle file upload error
                // You may want to add error handling here
            }

            // Set the image path in the entity
            $client->getPersonne()->setImagePersonne($newFilename);
        }

        // Save the client to the database
        $entityManager = $manager->getManager();
        $entityManager->persist($client);
        $entityManager->flush();

        // Redirect to the client list page
        return $this->redirectToRoute('client_list');
        }
    
        return $this->render('Front/client/addClient.html.twig', [
            'form_client' => $form->createView(),
        ]);
    }
    #[Route('/signUP', name: 'app_client_signUp')]
    public function signup(Request $request, ManagerRegistry $manager): Response {
        $client = new Client();
    
        $form = $this->createForm(RegistrationClientType::class, $client);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
                   // Get the uploaded file
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form['personne']['image_personne']->getData();

        // Check if a file was uploaded
        if ($uploadedFile) {
            // Generate a unique filename for the file
            $newFilename = uniqid().'.'.$uploadedFile->guessExtension();

            // Move the file to the desired directory
            try {
                $uploadedFile->move(
                    $this->getParameter('image_directory'), // Path to the directory where you want to save the file
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle file upload error
                // You may want to add error handling here
            }

            // Set the image path in the entity
            $client->getPersonne()->setImagePersonne($newFilename);
        }

        // Save the client to the database
        $entityManager = $manager->getManager();
        $entityManager->persist($client);
        $entityManager->flush();

            return $this->redirectToRoute('app_client_signIn');
        }
    
        return $this->render('Front/signUp.html.twig', [
            'form_client' => $form->createView(),
        ]);
    }
    #[Route('/editClient/{id}', name: 'app_client_edit')]
    public function editClient(Request $request, ClientRepository $clientRepository, EntityManagerInterface $entityManager, $id): Response {
        // Récupérer le client à éditer à partir de son identifiant
        $client = $clientRepository->find($id);
        
        // Créer le formulaire d'édition associé à l'entité Client
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager->flush();
    
            return $this->redirectToRoute('client_list'); // Rediriger vers la liste des clients après l'édition
        }
    
        // Get the image filename
        $clientImageFilename = $client->getPersonne()->getImagePersonne();
        
        // Check if the filename exists
        $clientImagePath = null;
        if ($clientImageFilename) {
            // Construct the full image path
            $clientImagePath = $this->getParameter('image_directory') . '/' . $clientImageFilename;
        }
    
        return $this->render('Front/client/editClient.html.twig', [
            'form_client' => $form->createView(),
            'client_image' => $clientImagePath // Pass the client's image path to the template
        ]);
    }
    
    


    #[Route('/deleteClient/{id}', name: 'app_client_delete')]
    public function deleteClient(ManagerRegistry $manager, ClientRepository $repo, $id): Response {
        $entityManager = $manager->getManager();

        $client= $repo->find($id);    
       
        $entityManager->remove($client);
        $entityManager->flush();
    
        return $this->redirectToRoute('client_list');
        

    
    }
}