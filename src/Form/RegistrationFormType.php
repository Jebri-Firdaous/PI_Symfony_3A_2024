<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    private $transformer;
    public function __construct(StringToFileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom_personne', null, [
            'label' => 'Nom',
            'attr' => ['placeholder' => 'Saisir votre nom'],
        ])
        ->add('prenom_personne', null, [
            'label' => 'Prénom',
            'attr' => ['placeholder' => 'Saisir votre prénom'],
        ])
        ->add('numero_telephone', IntegerType::class, [
            'attr' => [
                'placeholder' => 'Entrez votre numéro de téléphone',
            ],
            'required' => false, // Rend le champ optionnel
            ])

            ->add('image_personne', FileType::class, [
                'label' => 'Image',
                'required' => false, // Set to false if the field is not required
            ])    
       ->add('email', emailType::class, [
            'label' => 'Adresse Mail',
            'attr' => ['placeholder' => 'Saisir votre adresse mail'],
        ])           
         ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])

            
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de Passe',
                'attr' => ['autocomplete' => 'new-password'],
                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('Submit', SubmitType::class);

        ;
        if ($options['role'] === 'ADMIN') {
            $builder
            ->add('roleAdmin', ChoiceType::class, [
                'choices' => [
                    'Gestion Transport' => 'Gestion Transport',
                    'Gestion Santé' => 'Gestion Santé',
                    'Gestion Utilisateur' => 'Gestion Utilisateur',
                    'Gestion Parking' => 'Gestion Parking',
                    'Gestion Shopping' => 'Gestion Shopping',
                    'Gestion Tourisme' => 'Gestion Tourisme',
                    // Ajoutez d'autres choix si nécessaire
                ],
                'required' => false, // Rend le champ optionnel
                'placeholder' => 'Sélectionnez un role', // Placeholder par défaut
            ]);
            }
           if ($options['role'] === 'CLIENT') {
                $builder
                ->add('genre', ChoiceType::class, [
                    'choices' => [
                        'Femme' => 'Femme',
                        'Homme' => 'Homme',
                        'Autre' => 'Autre',
                    ],
                    'required' => false, // Rend le champ optionnel
                    'placeholder' => 'Sélectionnez un genre', // Placeholder par défaut
                ])
                ->add('age', IntegerType::class, [
                    'attr' => [
                        'placeholder' => 'Entrez votre âge',
                    ],
                ]);
                 // Add view transformer
    $builder->get('image_personne')->addModelTransformer($this->transformer);
    }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'role' => null,
        ]);
    }
}
