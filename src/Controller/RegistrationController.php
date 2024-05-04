<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user,[ 'role' => "CLIENT"]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
                 /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form['image_personne']->getData();

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
            $user->setImagePersonne($newFilename);
        }
            $user->setRoles(['CLIENT']);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/registerAdmin', name: 'app_register_admin')]
    public function registerAdmin(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user,[ 'role' => "ADMIN"]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
                             /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form['image_personne']->getData();

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
            $user->setImagePersonne($newFilename);
        }
            $user->setRoles(['ADMIN']);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
