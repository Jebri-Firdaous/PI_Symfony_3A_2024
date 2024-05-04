<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Personne;
use App\Form\AdministrateurType;
use App\Form\PersonneType;
use App\Form\RegistrationAdminType;
use App\Repository\AdministrateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mime\email;


class AdministrateurController extends AbstractController
{
    #[Route('/adminGetAll', name: 'administrateur_list')]
    public function listAdministrateur(AdministrateurRepository $repo): Response
    {
        $list=$repo->findAll();
        return $this->render('Back/administrateur/index.html.twig', [
            'list' => $list,
        ]);
    }
    #[Route('/addAdmin', name: 'app_administrateur_add')]
    
    public function addAdmin(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $passwordEncoder): Response {
        $administrateur = new Administrateur();
    
        $form = $this->createForm(AdministrateurType::class, $administrateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $mdp_personne = $form['personne']['mdp_personne']->getData();
            $mdp_hashed = $passwordEncoder->encodePassword($administrateur, $mdp_personne);
            $administrateur->getPersonne()->setMdpPersonne($mdp_hashed);
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
            $administrateur->getPersonne()->setImagePersonne($newFilename);
        }
            $entityManager = $manager->getManager();
            $entityManager->persist($administrateur);
            $entityManager->flush();
    
            return $this->redirectToRoute('administrateur_list');
        }
    
        return $this->render('Back/administrateur/addAdmin.html.twig', [
            'form_admin' => $form->createView(),
        ]);
    }
    #[Route('/editAdmin/{id}', name: 'app_administrateur_edit')]
    public function editAdmin(Request $request,  EntityManagerInterface $entityManager, AdministrateurRepository $repo, $id): Response {

        $administrateur= $repo->find($id);
        $form = $this->createForm(AdministrateurType::class, $administrateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
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
     $administrateur->getPersonne()->setImagePersonne($newFilename);
 } 
            $entityManager->flush();
    
            return $this->redirectToRoute('administrateur_list');
        }
             // Get the image filename
             $adminImageFilename = $administrateur->getPersonne()->getImagePersonne();
        
             // Check if the filename exists
             $adminImagePath = null;
             if ($adminImageFilename) {
                 // Construct the full image path
                 $adminImagePath = $this->getParameter('image_directory') . '/' . $adminImageFilename;
             }
    
        return $this->render('Back/administrateur/editAdmin.html.twig', [
            'form_admin' => $form->createView(),
            'admin_image' => $adminImagePath // Pass the admin's image path to the template

        
        ]);
    }
    #[Route('/deleteAdmin/{id}', name: 'app_administrateur_delete')]
    public function deleteAdmin(ManagerRegistry $manager, AdministrateurRepository $repo, $id): Response {
        $entityManager = $manager->getManager();

        $administrateur= $repo->find($id);    
       
        $entityManager->remove($administrateur);
        $entityManager->flush();
    
        return $this->redirectToRoute('administrateur_list');
        

    
    }
    
    #[Route('/adminSignIn', name: 'app_admin_signIn')]
    public function adminsignIn(AdministrateurRepository $repo): Response
    {
        
        return $this->render('Back/signIn.html.twig', [
           
        ]);
    }
    #[Route('/adminSignUP', name: 'app_admin_signUp')]
    public function signup(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $passwordEncoder,  MailerInterface $mailer): Response {
        $admin = new Administrateur();
    
        $form = $this->createForm(AdministrateurType::class, $admin);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form);
            $mdp_personne = $form['personne']['mdp_personne']->getData();
            $mdp_hashed = $passwordEncoder->encodePassword($admin, $mdp_personne);
            $admin->getPersonne()->setMdpPersonne($mdp_hashed);
            $verificationCode = random_int(100000, 999999); // Generate a 6-digit code
            $email = (new email())
            ->from('jebrifirdaous0@gmail.com')
            ->to($admin->getPersonne()->getMailPersonne())
            ->subject('Verification Code for E-CITY')
            ->html('<p>Your verification code is: ' . $verificationCode . '</p>');

        // Send the email using Symfony Mailer
        $mailer->send($email);
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
                $admin->getPersonne()->setImagePersonne($newFilename);
            }

            // Save the admin to the database
            $entityManager = $manager->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_signIn');
        }
    
        return $this->render('Back/signUp.html.twig', [
            'form_admin' => $form->createView(),
        ]);
    }
}