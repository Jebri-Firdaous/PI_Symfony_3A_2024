<?php




namespace App\Controller;




use App\Entity\User;

use App\Form\RegistrationFormType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use Symfony\Component\Mime\Email;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Component\Mime\Address;














class RegistrationController extends AbstractController

{

    public function __construct(

        private EntityManagerInterface $entityManager

    ) {

    }

    #[Route('/register', name: 'app_register')]

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer): Response

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

            $this->sendVerificationEmail($user, $mailer);




            return $this->redirectToRoute('app_check_useremail');

        }




        return $this->render('registration/register.html.twig', [

            'registrationForm' => $form->createView(),

        ]);

    }

    #[Route('/registerAdmin', name: 'app_register_admin')]

    public function registerAdmin(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer): Response

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

            $this->sendVerificationEmail($user, $mailer);




            return $this->redirectToRoute('app_check_useremail');

        }




        return $this->render('registration/register.html.twig', [

            'registrationForm' => $form->createView(),

        ]);

    }

    private function sendVerificationEmail(User $user, MailerInterface $mailer): void

{

    $email = (new TemplatedEmail())

        ->from(new Address('jebrifirdaous0@gmail.com', 'E-City Bot'))

        ->to($user->getEmail())

        ->subject('Vérification de votre compte')

        ->htmlTemplate('verify/email.html.twig')

        ->context([

            'user' => $user,

        ]);




    $mailer->send($email);

}

    #[Route('/check-email', name: 'app_check_useremail')]

    public function checkemail(): Response

    {

        // Generate a fake token if the user does not exist or someone hit this page directly.

        // This prevents exposing whether or not a user was found with the given email address or not

    




        return $this->render('verify/check_email.html.twig', [

        ]);

    }

    #[Route('/check-email/verify-email/{id}', name: 'app_verify_useremail')]

    public function verifyemail($id): Response

    {

        // Récupérer l'utilisateur par son ID

        $user = $this->entityManager->getRepository(User::class)->find($id);

    

        // Si l'utilisateur existe

        if ($user !== null) {

            // Mettre à jour le statut de vérification

            $user->setIsVerified(true);

    

            // Enregistrer les modifications dans la base de données

            $this->entityManager->flush();

        }

    

        // Afficher une page de confirmation de la vérification

        return $this->render('verify/verify_email.html.twig', [

            'user' => $user,

        ]);

    }

    

}




