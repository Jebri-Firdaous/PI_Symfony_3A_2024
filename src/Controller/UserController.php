<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserTypeAdmin;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;


#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request,UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['role' => 'CLIENT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['CLIENT']);
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

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index');
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    
    #[Route('/newAdmin', name: 'app_user_new_admin', methods: ['GET', 'POST'])]
    public function newadmin(Request $request,UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserTypeAdmin::class, $user, ['role' => 'ADMIN']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ADMIN']);
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

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index_admin');
        }

        return $this->renderForm('user/newadmin.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Route('/admin', name: 'app_user_index_admin', methods: ['GET'])]
    public function indexadmin(UserRepository $userRepository): Response
    {
        return $this->render('user/indexadmin.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
    

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserTypeAdmin::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            $entityManager->flush();
            

            return $this->redirectToRoute('app_user_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    
    #[Route('/delete/{id}', name: 'app_user_delete')]
    public function delete(ManagerRegistry $manager, UserRepository $repo, $id): Response
    {
       // Vérifier si le jeton CSRF est valide
       $entityManager = $manager->getManager();

       $user= $repo->find($id);    
      
       $entityManager->remove($user);
       $entityManager->flush();
   
       // Rediriger vers la page d'index des utilisateurs après la suppression
       return $this->redirectToRoute('app_user_index');
    }
    
    #[Route('/deleteAdmin/{id}', name: 'app_user_delete_admin')]
    public function deleteAdmin(ManagerRegistry $manager, UserRepository $repo, $id): Response
    {
       // Vérifier si le jeton CSRF est valide
       $entityManager = $manager->getManager();

       $user= $repo->find($id);    
      
       $entityManager->remove($user);
       $entityManager->flush();
   
       // Rediriger vers la page d'index des utilisateurs après la suppression
       return $this->redirectToRoute('app_user_index_admin');
    }

}
