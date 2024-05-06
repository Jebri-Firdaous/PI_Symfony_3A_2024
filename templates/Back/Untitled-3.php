    #[Route('/adminSignIn', name: 'app_admin_signIn')]
    public function adminsignIn(AdministrateurRepository $repo): Response
    {
        
        return $this->render('Back/signIn.html.twig', [
           
        ]);
    }
    #[Route('/adminSignUP', name: 'app_admin_signUp')]
    public function signup(Request $request, ManagerRegistry $manager): Response {
        $admin = new Administrateur();
    
        $form = $this->createForm(AdministrateurType::class, $admin);
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